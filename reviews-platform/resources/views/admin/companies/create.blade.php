<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cadastrar Nova Empresa
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            {{-- Barra de Progresso --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900">CRIAR EMPRESA - VERSÃO ATUALIZADA: {{ time() }}</h2>
                <div class="mt-4 flex items-center justify-between">
                    <span class="text-sm text-gray-600">
                        <span id="progress-text">0/6</span> etapas completas
                    </span>
                    <div class="flex-1 mx-4">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div 
                                id="progress-bar"
                                class="bg-purple-600 h-2 rounded-full transition-all duration-300"
                                style="width: 0%"
                            ></div>
                        </div>
                    </div>
                    <span class="text-sm text-purple-600">
                        (O que está faltando?)
                    </span>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                
                <form action="{{ route('admin.companies.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Nome da Empresa --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nome da Empresa *
                        </label>
                        <input type="text" 
                               name="name" 
                               id="name" 
                               value="{{ old('name') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               required>
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- E-mail --}}
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            E-mail de Contato *
                        </label>
                        <input type="email" 
                               name="email" 
                               id="email" 
                               value="{{ old('email') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               required>
                        <p class="text-xs text-gray-500 mt-1">E-mail para receber as notificações de avaliações</p>
                        @error('email')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Logo --}}
                    <div class="mb-4">
                        <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                            Logo da Empresa
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <div id="logo-preview" class="hidden">
                                    <img id="logo-preview-img" class="mx-auto h-20 w-20 object-contain" />
                                    <button type="button" id="logo-remove" class="mt-2 text-red-600 text-sm">Remover</button>
                                </div>
                                <div id="logo-upload">
                                    <span class="text-4xl">📷</span>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="logo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                            <span>Upload do logo</span>
                                            <input
                                                id="logo"
                                                name="logo"
                                                type="file"
                                                accept="image/*"
                                                class="sr-only"
                                            />
                                        </label>
                                        <p class="pl-1">ou arraste e solte</p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG até 2MB</p>
                            </div>
                        </div>
                        @error('logo')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Imagem de Fundo --}}
                    <div class="mb-4">
                        <label for="background_image" class="block text-sm font-medium text-gray-700 mb-2">
                            Imagem de Fundo
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <div id="background-preview" class="hidden">
                                    <img id="background-preview-img" class="mx-auto h-20 w-32 object-cover rounded" />
                                    <button type="button" id="background-remove" class="mt-2 text-red-600 text-sm">Remover</button>
                                </div>
                                <div id="background-upload">
                                    <span class="text-4xl">🖼️</span>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="background_image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                            <span>Upload da imagem</span>
                                            <input
                                                id="background_image"
                                                name="background_image"
                                                type="file"
                                                accept="image/*"
                                                class="sr-only"
                                            />
                                        </label>
                                        <p class="pl-1">ou arraste e solte</p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG até 5MB</p>
                            </div>
                        </div>
                        @error('background_image')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- URL do Google Reviews --}}
                    <div class="mb-4">
                        <label for="google_review_url" class="block text-sm font-medium text-gray-700 mb-2">
                            URL do Google Reviews *
                        </label>
                        <input type="url" 
                               name="google_review_url" 
                               id="google_review_url" 
                               value="{{ old('google_review_url') }}"
                               placeholder="https://g.page/..."
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               required>
                        <p class="text-xs text-gray-500 mt-1">Link direto para avaliação no Google</p>
                        @error('google_review_url')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Threshold de Avaliação Positiva --}}
                    <div class="mb-6">
                        <label for="positive_threshold" class="block text-sm font-medium text-gray-700 mb-2">
                            Limite de Avaliação Positiva: <span id="threshold-value" class="font-bold">4</span> estrelas
                        </label>
                        <input type="range" 
                               name="positive_threshold" 
                               id="positive_threshold" 
                               min="1" 
                               max="5" 
                               value="{{ old('positive_threshold', 4) }}"
                               class="w-full">
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>1 ⭐</span>
                            <span>2 ⭐</span>
                            <span>3 ⭐</span>
                            <span>4 ⭐</span>
                            <span>5 ⭐</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            Avaliações ≥ este valor serão consideradas positivas e redirecionadas ao Google
                        </p>
                        @error('positive_threshold')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Botões --}}
                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Criar Empresa
                        </button>
                        <a href="{{ route('admin.companies.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                            Cancelar
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <script>
        // Elementos da barra de progresso
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        
        // Elementos do slider
        const slider = document.getElementById('positive_threshold');
        const valueDisplay = document.getElementById('threshold-value');
        
        // Elementos de upload
        const logoInput = document.getElementById('logo');
        const backgroundInput = document.getElementById('background_image');
        const logoPreview = document.getElementById('logo-preview');
        const logoPreviewImg = document.getElementById('logo-preview-img');
        const logoUpload = document.getElementById('logo-upload');
        const logoRemove = document.getElementById('logo-remove');
        const backgroundPreview = document.getElementById('background-preview');
        const backgroundPreviewImg = document.getElementById('background-preview-img');
        const backgroundUpload = document.getElementById('background-upload');
        const backgroundRemove = document.getElementById('background-remove');
        
        // Campos obrigatórios
        const requiredFields = ['name', 'email', 'google_review_url'];
        
        // Função para atualizar progresso
        function updateProgress() {
            let completedFields = 0;
            const totalFields = requiredFields.length + 2; // +2 para logo e background
            
            // Verificar campos obrigatórios
            requiredFields.forEach(fieldName => {
                const field = document.getElementById(fieldName);
                if (field && field.value.trim() !== '') {
                    completedFields++;
                }
            });
            
            // Verificar arquivos
            if (logoInput.files.length > 0) completedFields++;
            if (backgroundInput.files.length > 0) completedFields++;
            
            const progress = Math.min(Math.ceil((completedFields / totalFields) * 6), 6);
            const percentage = (progress / 6) * 100;
            
            progressBar.style.width = percentage + '%';
            progressText.textContent = progress + '/6';
        }
        
        // Função para preview de imagem
        function handleFileUpload(input, preview, previewImg, uploadDiv, removeBtn) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                    uploadDiv.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }
        }
        
        // Função para remover arquivo
        function removeFile(input, preview, uploadDiv) {
            input.value = '';
            preview.classList.add('hidden');
            uploadDiv.classList.remove('hidden');
        }
        
        // Event listeners
        slider.addEventListener('input', function() {
            valueDisplay.textContent = this.value;
            updateProgress();
        });
        
        // Upload de logo
        logoInput.addEventListener('change', function() {
            handleFileUpload(this, logoPreview, logoPreviewImg, logoUpload, logoRemove);
            updateProgress();
        });
        
        logoRemove.addEventListener('click', function() {
            removeFile(logoInput, logoPreview, logoUpload);
            updateProgress();
        });
        
        // Upload de imagem de fundo
        backgroundInput.addEventListener('change', function() {
            handleFileUpload(this, backgroundPreview, backgroundPreviewImg, backgroundUpload, backgroundRemove);
            updateProgress();
        });
        
        backgroundRemove.addEventListener('click', function() {
            removeFile(backgroundInput, backgroundPreview, backgroundUpload);
            updateProgress();
        });
        
        // Atualizar progresso quando campos são preenchidos
        requiredFields.forEach(fieldName => {
            const field = document.getElementById(fieldName);
            if (field) {
                field.addEventListener('input', updateProgress);
                field.addEventListener('change', updateProgress);
            }
        });
        
        // Inicializar progresso
        updateProgress();
        
        console.log('Script de upload e progresso carregado com sucesso! - VERSÃO ATUALIZADA: <?php echo time(); ?>');
    </script>
</x-app-layout>
