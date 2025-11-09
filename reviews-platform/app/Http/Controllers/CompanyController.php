<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ReviewPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Company::with('user')->withCount(['reviews', 'reviewPages']);
        
        // Admin e Proprietário vêem todas as empresas
        if (!in_array($user->role, ['admin', 'proprietario'])) {
            // User comum vê apenas suas empresas
            $query->where('user_id', $user->id);
        }
        
        // Filter by user (company owner) - only for admin and owner
        if ($request->has('user_id') && $request->user_id && in_array($user->role, ['admin', 'proprietario'])) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter by status
        if ($request->has('status') && $request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        // Filter by visibility (is_active)
        if ($request->has('visibility') && $request->visibility && $request->visibility !== 'all') {
            if ($request->visibility === 'visible') {
                $query->where('is_active', true);
            } elseif ($request->visibility === 'hidden') {
                $query->where('is_active', false);
            }
        }
        
        // Filter by rating limit (positive_score)
        if ($request->has('rating_limit') && $request->rating_limit && $request->rating_limit !== 'all') {
            $query->where('positive_score', $request->rating_limit);
        }
        
        // Filter by reviews count
        if ($request->has('reviews_filter') && $request->reviews_filter && $request->reviews_filter !== 'all') {
            if ($request->reviews_filter === 'with_reviews') {
                $query->has('reviews');
            } elseif ($request->reviews_filter === 'without_reviews') {
                $query->doesntHave('reviews');
            }
        }
        
        // Filter by date period
        if ($request->has('period') && $request->period && $request->period !== 'all') {
            $now = now();
            switch ($request->period) {
                case 'today':
                    $query->whereDate('created_at', $now->toDateString());
                    break;
                case 'week':
                    $query->where('created_at', '>=', $now->copy()->subWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', $now->copy()->subMonth());
                    break;
            }
        }
        
        // Search by name
        if ($request->has('search') && $request->search) {
            $searchTerm = '%' . $request->search . '%';
            $query->where('name', 'LIKE', $searchTerm);
        }
        
        // Order by
        $query->orderBy('status', 'asc')
              ->orderBy('created_at', 'desc');
        
        $companies = $query->paginate(12)->appends($request->query());
        
        // Get users list for filter (only for admin/owner)
        $users = collect(); // Empty collection by default
        if (in_array($user->role, ['admin', 'proprietario'])) {
            $users = \App\Models\User::whereHas('companies')->orderBy('name')->get();
        }
            
        return view('companies', compact('companies', 'users'));
    }

    public function create()
    {
        // Usuários agora podem criar quantas empresas quiserem
        return view('companies-create');
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        // Usuários agora podem criar quantas empresas/páginas de avaliação quiserem
        \Log::info('CompanyController@store chamado', ['request_data' => $request->all()]);
        
        // Determinar se é rascunho ou publicação
        $isDraft = $request->has('save_as_draft') && $request->save_as_draft === 'true';
        
        // Validação diferente para rascunho vs publicação
        if ($isDraft) {
            // Validação mais flexível para rascunho
            $request->validate([
                'name' => 'nullable|string|max:255',
                'url' => 'nullable|string|max:255',
                'negative_email' => 'nullable|email',
                'contact_number' => 'nullable|string|max:20',
                'business_website' => 'nullable|string|max:500',
                'business_address' => 'nullable|string|max:500',
                'google_business_url' => 'nullable|string|max:500',
                'positive_score' => 'nullable|integer|min:1|max:5',
                'logo' => 'nullable|file|max:2048',
                'background_image' => 'nullable|file|max:2048',
            ]);
        } else {
            // Validação completa para publicação
            $request->validate([
                'name' => 'required|string|max:255',
                'url' => 'nullable|string|max:255',
                'negative_email' => 'required|email',
                'contact_number' => 'nullable|string|max:20',
                'business_website' => 'nullable|string|max:500',
                'business_address' => 'nullable|string|max:500',
                'google_business_url' => 'nullable|string|max:500',
                'positive_score' => 'required|integer|min:1|max:5',
                'logo' => 'nullable|file|max:2048',
                'background_image' => 'nullable|file|max:2048',
            ]);
        }

        \Log::info('Validação passou com sucesso', ['is_draft' => $isDraft]);
        
        $data = $request->all();
        
        // Normalizar Google Business URL - adicionar https:// se não tiver protocolo
        if (isset($data['google_business_url']) && !empty($data['google_business_url'])) {
            $data['google_business_url'] = $this->normalizeGoogleBusinessUrl($data['google_business_url']);
        }
        
        // Adicionar user_id automaticamente
        $data['user_id'] = $user->id;
        
        // Handle file uploads with compression
        if ($request->hasFile('logo')) {
            $data['logo'] = $this->compressAndStoreImage($request->file('logo'), 'logos', 800, 800, 85);
        }
        
        if ($request->hasFile('background_image')) {
            $data['background_image'] = $this->compressAndStoreImage($request->file('background_image'), 'backgrounds', 1920, 1080, 80);
        }

        // Definir status
        $data['status'] = $isDraft ? 'draft' : 'published';

        // Create company
        \Log::info('Criando empresa', ['data' => $data]);
        $company = Company::create($data);
        \Log::info('Empresa criada', ['company_id' => $company->id, 'token' => $company->token, 'status' => $company->status]);

        if (!$isDraft) {
            // Create review page apenas para empresas publicadas
            \Log::info('Criando review page');
            $reviewPage = ReviewPage::create([
                'company_id' => $company->id,
                'token' => $company->token,
                'url' => $company->public_url,
            ]);
            \Log::info('Review page criada', ['review_page_id' => $reviewPage->id]);

            \Log::info('Redirecionando para página pública', ['token' => $company->token]);
            return redirect()->route('public.review-page', ['token' => $company->token])
                ->with('success', 'Empresa ativada com sucesso! Sua página pública está pronta!');
        } else {
            // Para rascunhos, redirecionar para página de edição
            \Log::info('Redirecionando para página de edição', ['company_id' => $company->id]);
            return redirect()->route('companies.edit', ['id' => $company->id])
                ->with('success', 'Empresa salva como rascunho! Você pode continuar editando e publicar quando estiver pronto.');
        }
    }

    public function show($token)
    {
        $company = Company::where('token', $token)->firstOrFail();
        $reviews = $company->reviews()->orderBy('created_at', 'desc')->get();
        
        return view('public.review-page', compact('company', 'token', 'reviews'));
    }

    public function edit($id)
    {
        $user = auth()->user();
        $company = Company::findOrFail($id);
        
        // Verificar se o usuário tem permissão para editar
        if ($user->role === 'user' && $company->user_id !== $user->id) {
            return redirect()->route('companies.index')
                ->with('error', 'Você não tem permissão para editar esta empresa.');
        }
        
        // Permitir edição mesmo se publicada
        
        return view('companies-edit', compact('company'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        \Log::info('CompanyController@update chamado', ['company_id' => $id, 'request_data' => $request->all()]);
        
        $company = Company::findOrFail($id);
        
        // Verificar se o usuário tem permissão para editar
        if ($user->role === 'user' && $company->user_id !== $user->id) {
            return redirect()->route('companies.index')
                ->with('error', 'Você não tem permissão para editar esta empresa.');
        }
        
        // Permitir edição mesmo se publicada
        
        // Determinar se é rascunho ou publicação
        $isDraft = $request->has('save_as_draft') && $request->save_as_draft === 'true';
        
        // Validação diferente para rascunho vs publicação
        if ($isDraft) {
            // Validação mais flexível para rascunho
            $request->validate([
                'name' => 'nullable|string|max:255',
                'url' => 'nullable|string|max:255',
                'negative_email' => 'nullable|email',
                'contact_number' => 'nullable|string|max:20',
                'business_website' => 'nullable|string|max:500',
                'business_address' => 'nullable|string|max:500',
                'google_business_url' => 'nullable|string|max:500',
                'positive_score' => 'nullable|integer|min:1|max:5',
                'logo' => 'nullable|file|max:2048',
                'background_image' => 'nullable|file|max:2048',
            ]);
        } else {
            // Validação completa para publicação
            $request->validate([
                'name' => 'required|string|max:255',
                'url' => 'nullable|string|max:255',
                'negative_email' => 'required|email',
                'contact_number' => 'nullable|string|max:20',
                'business_website' => 'nullable|string|max:500',
                'business_address' => 'nullable|string|max:500',
                'google_business_url' => 'nullable|string|max:500',
                'positive_score' => 'required|integer|min:1|max:5',
                'logo' => 'nullable|file|max:2048',
                'background_image' => 'nullable|file|max:2048',
            ]);
        }

        \Log::info('Validação passou com sucesso', ['is_draft' => $isDraft]);
        
        $data = $request->all();
        
        // Normalizar Google Business URL - adicionar https:// se não tiver protocolo
        if (isset($data['google_business_url']) && !empty($data['google_business_url'])) {
            $data['google_business_url'] = $this->normalizeGoogleBusinessUrl($data['google_business_url']);
        }
        
        // Salvar referências das imagens antigas
        $oldLogo = $company->logo;
        $oldBackground = $company->background_image;
        
        // Handle file uploads - Logo with compression
        \Log::info('Checking for logo file', [
            'hasFile' => $request->hasFile('logo'),
            'hasLogoInput' => $request->has('logo'),
            'allFiles' => array_keys($request->allFiles())
        ]);
        
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            \Log::info('Logo file received', [
                'originalName' => $logoFile->getClientOriginalName(),
                'mimeType' => $logoFile->getMimeType(),
                'size' => $logoFile->getSize(),
                'isValid' => $logoFile->isValid()
            ]);
            
            // Deletar logo antiga se existir
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            
            // Salvar nova logo com compressão
            try {
                $logoPath = $this->compressAndStoreImage($logoFile, 'logos', 800, 800, 85);
                \Log::info('Logo path returned', [
                    'path' => $logoPath, 
                    'file_exists' => Storage::disk('public')->exists($logoPath),
                    'full_path' => Storage::disk('public')->path($logoPath)
                ]);
                $data['logo'] = $logoPath;
            } catch (\Exception $e) {
                \Log::error('Error processing logo: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString()
                ]);
                // Se houver erro, manter a logo antiga
                if ($oldLogo) {
                    $data['logo'] = $oldLogo;
                } else {
                    unset($data['logo']);
                }
            }
        } else {
            \Log::info('No logo file in request, preserving old logo');
            // Preservar logo antiga se não houver novo upload
            unset($data['logo']);
        }
        
        // Handle file uploads - Background Image with compression
        if ($request->hasFile('background_image')) {
            // Deletar background antigo se existir
            if ($oldBackground && Storage::disk('public')->exists($oldBackground)) {
                Storage::disk('public')->delete($oldBackground);
            }
            // Salvar novo background com compressão
            $data['background_image'] = $this->compressAndStoreImage($request->file('background_image'), 'backgrounds', 1920, 1080, 80);
        } else {
            // Preservar background antigo se não houver novo upload
            unset($data['background_image']);
        }

        // Remover campos de arquivo vazios do array (já removidos acima se não houver upload)

        // Definir status
        $data['status'] = $isDraft ? 'draft' : 'published';

        // Update company
        \Log::info('Atualizando empresa', ['data' => $data]);
        $company->update($data);
        
        // Recarregar a empresa do banco para garantir dados atualizados
        $company->refresh();
        
        \Log::info('Empresa atualizada', [
            'company_id' => $company->id, 
            'status' => $company->status,
            'logo' => $company->logo,
            'logo_url' => $company->logo_url
        ]);

        if (!$isDraft && $company->status === 'published') {
            // Create review page se não existir
            if (!$company->reviewPages()->exists()) {
                \Log::info('Criando review page');
                $reviewPage = ReviewPage::create([
                    'company_id' => $company->id,
                    'token' => $company->token,
                    'url' => $company->public_url,
                ]);
                \Log::info('Review page criada', ['review_page_id' => $reviewPage->id]);
            }

            \Log::info('Redirecionando para página pública', ['token' => $company->token]);
            return redirect()->route('public.review-page', ['token' => $company->token])
                ->with('success', 'Empresa ativada com sucesso! Sua página pública está pronta!');
        } else {
            // Para rascunhos, redirecionar para página de edição
            \Log::info('Redirecionando para página de edição', ['company_id' => $company->id]);
            return redirect()->route('companies.edit', ['id' => $company->id])
                ->with('success', 'Empresa salva como rascunho! Você pode continuar editando e publicar quando estiver pronto.');
        }
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $company = Company::findOrFail($id);
        
        // Verificar se o usuário tem permissão para excluir
        if ($user->role === 'user' && $company->user_id !== $user->id) {
            return redirect()->route('companies.index')
                ->with('error', 'Você não tem permissão para excluir esta empresa.');
        }
        
        $company->delete();
        
        return redirect()->route('companies.index')
            ->with('success', 'Empresa excluída com sucesso!');
    }

    /**
     * Compress and store image with optimization
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @param int $maxWidth
     * @param int $maxHeight
     * @param int $quality (1-100)
     * @return string
     */
    private function compressAndStoreImage($file, $folder, $maxWidth, $maxHeight, $quality = 85)
    {
        try {
            // Check if Intervention Image is available and working
            if (class_exists('Intervention\Image\Facades\Image')) {
                try {
                    $image = Image::make($file);
                } catch (\Exception $e) {
                    \Log::warning('Intervention Image failed, falling back: ' . $e->getMessage());
                    // Fall through to GD or direct storage
                    return $this->compressWithGD($file, $folder, $maxWidth, $maxHeight, $quality);
                }
                
                // Resize maintaining aspect ratio
                $image->resize($maxWidth, $maxHeight, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                // Convert to RGB if needed (for better compression)
                if ($image->mime() === 'image/png') {
                    $image->encode('jpg', $quality);
                    $extension = 'jpg';
                } else {
                    $image->encode($file->getClientOriginalExtension(), $quality);
                    $extension = $file->getClientOriginalExtension();
                }
                
                // Generate unique filename
                $filename = uniqid($folder . '_') . '.' . $extension;
                $path = $folder . '/' . $filename;
                
                // Store compressed image
                Storage::disk('public')->put($path, (string) $image);
                
                return $path;
            } else {
                // Fallback: use GD library if Intervention Image is not available
                return $this->compressWithGD($file, $folder, $maxWidth, $maxHeight, $quality);
            }
        } catch (\Exception $e) {
            \Log::error('Error compressing image: ' . $e->getMessage());
            // Fallback to original storage method
            $storedPath = $file->store($folder, 'public');
            // Garantir que o caminho não tenha o prefixo do disco
            return str_replace('public/', '', $storedPath);
        }
    }

    /**
     * Compress image using GD library (fallback)
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @param int $maxWidth
     * @param int $maxHeight
     * @param int $quality
     * @return string
     */
    private function compressWithGD($file, $folder, $maxWidth, $maxHeight, $quality)
    {
        // Check if GD extension is available
        if (!extension_loaded('gd') || !function_exists('imagecreatefromjpeg')) {
            \Log::warning('GD extension not available, storing image without compression');
            $storedPath = $file->store($folder, 'public');
            // Garantir que o caminho não tenha o prefixo do disco
            return str_replace('public/', '', $storedPath);
        }
        
        $extension = strtolower($file->getClientOriginalExtension());
        $mimeType = $file->getMimeType();
        
        // Create image resource based on type
        if ($mimeType === 'image/jpeg' || $mimeType === 'image/jpg') {
            $sourceImage = \imagecreatefromjpeg($file->getRealPath());
        } elseif ($mimeType === 'image/png') {
            $sourceImage = \imagecreatefrompng($file->getRealPath());
        } elseif ($mimeType === 'image/gif') {
            $sourceImage = \imagecreatefromgif($file->getRealPath());
        } else {
            // Unsupported format, use original storage
            $storedPath = $file->store($folder, 'public');
            return str_replace('public/', '', $storedPath);
        }
        
        if (!$sourceImage) {
            $storedPath = $file->store($folder, 'public');
            return str_replace('public/', '', $storedPath);
        }
        
        // Get original dimensions
        $originalWidth = \imagesx($sourceImage);
        $originalHeight = \imagesy($sourceImage);
        
        // Calculate new dimensions maintaining aspect ratio
        $ratio = min($maxWidth / $originalWidth, $maxHeight / $originalHeight);
        $newWidth = (int)($originalWidth * $ratio);
        $newHeight = (int)($originalHeight * $ratio);
        
        // Create new image
        $newImage = \imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserve transparency for PNG
        if ($extension === 'png') {
            \imagealphablending($newImage, false);
            \imagesavealpha($newImage, true);
            $transparent = \imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            \imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
        }
        
        // Resize image
        \imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);
        
        // Generate filename
        $filename = uniqid($folder . '_') . '.jpg'; // Always save as JPG for better compression
        $path = $folder . '/' . $filename;
        $fullPath = Storage::disk('public')->path($path);
        
        // Ensure directory exists
        $directory = dirname($fullPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        
        // Save compressed image as JPEG
        \imagejpeg($newImage, $fullPath, $quality);
        
        // Free memory
        \imagedestroy($sourceImage);
        \imagedestroy($newImage);
        
        return $path;
    }

    /**
     * Normalize Google Business URL - add https:// if protocol is missing
     * 
     * @param string $url
     * @return string
     */
    private function normalizeGoogleBusinessUrl($url)
    {
        if (empty($url)) {
            return $url;
        }

        // Remove espaços em branco
        $url = trim($url);

        // Se já tiver protocolo (http:// ou https://), retorna como está
        if (preg_match('/^https?:\/\//i', $url)) {
            return $url;
        }

        // Se começar com www., adiciona https://
        if (preg_match('/^www\./i', $url)) {
            return 'https://' . $url;
        }

        // Para outros casos, adiciona https://
        return 'https://' . $url;
    }
}
