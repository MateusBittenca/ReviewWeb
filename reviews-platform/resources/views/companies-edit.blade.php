@extends('layouts.admin')

@section('title', __('companies.edit') . ' - ' . __('app.name'))

@section('page-title', __('companies.edit') . ': ' . $company->name)

@section('header-actions')
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-4 w-full sm:w-auto">
        <a href="/companies" class="text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors text-center sm:text-left px-3 py-2 sm:px-0 sm:py-0">
            <i class="fas fa-arrow-left mr-2"></i>
            {{ __('companies.back') }}
        </a>
        <span class="px-3 py-1 text-sm font-medium rounded-full {{ $company->status === 'published' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' }} text-center whitespace-nowrap">
            {{ $company->status === 'published' ? __('companies.active') : __('companies.draft') }}
        </span>
        <button type="button" onclick="submitForm()" class="btn-primary text-white px-4 py-2 rounded-lg font-medium min-h-[44px] flex items-center justify-center">
            <i class="fas fa-upload mr-2"></i>
            {{ __('companies.activate') }}
        </button>
        <button type="button" onclick="saveForm()" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium min-h-[44px] flex items-center justify-center">
            <i class="fas fa-save mr-2"></i>
            {{ __('companies.save') }}
        </button>
    </div>
@endsection

@section('styles')
<style>
    .upload-area {
        border: 2px dashed #d1d5db;
        transition: all 0.3s ease;
    }
    .upload-area:hover {
        border-color: var(--primary-color);
        background-color: rgba(139, 92, 246, 0.05);
    }
    
    /* Cropper Modal Styles */
    #cropModal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        overflow-y: auto;
    }
    
    #cropModal.show {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .crop-modal-content {
        background-color: white;
        padding: 1rem;
        border-radius: 16px;
        width: 80vw;
        height: auto;
        max-width: 800px;
        overflow-y: auto;
        position: relative;
        z-index: 10000;
        margin: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        pointer-events: auto !important;
        display: flex;
        flex-direction: column;
        max-height: 90vh;
    }
    
    @media (min-width: 640px) {
        .crop-modal-content {
            padding: 1.5rem;
        }
    }
    
    @media (max-width: 639px) {
        .crop-modal-content {
            width: 95%;
            padding: 1rem;
        }
    }
    
    .crop-modal-header {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e5e7eb;
        flex-shrink: 0;
    }
    
    .crop-modal-header h3 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
    }
    
    .crop-modal-header p {
        margin: 0.5rem 0 0 0;
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    #cropImageContainer {
        width: 100%;
        height: 420px;
        background-color: #f3f4f6;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        touch-action: none;
    }
    
    @media (max-width: 639px) {
        #cropImageContainer {
            height: 300px;
            margin-bottom: 1rem;
        }
    }

    #cropperImage {
        display: none;
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        object-fit: contain;
        border-radius: 12px;
        user-select: none;
        visibility: visible;
        opacity: 1;
    }
    
    #cropImageContainer #cropperImage[style*="display: block"] {
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
    }

    .crop-overlay {
        position: absolute;
        inset: 0;
        pointer-events: none;
        display: none;
    }

    .crop-overlay.active {
        display: block;
    }

    #cropBox {
        position: absolute;
        border: 2px solid rgba(47, 128, 237, 0.95);
        box-shadow: 0 0 0 9999px rgba(15, 23, 42, 0.55);
        border-radius: 8px;
        background: rgba(47, 128, 237, 0.12);
        cursor: move;
        pointer-events: auto;
        display: none;
    }

    #cropBox.active {
        display: block;
    }

    #cropBox::before {
        content: "";
        position: absolute;
        inset: 0;
        border-radius: 6px;
        background-image:
            linear-gradient(rgba(255,255,255,0.35) 0, rgba(255,255,255,0.35) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.35) 0, rgba(255,255,255,0.35) 1px, transparent 1px);
        background-size: 100% calc(100%/3), calc(100%/3) 100%;
        background-position: 0 calc(100%/3), calc(100%/3) 0;
        pointer-events: none;
    }

    .crop-handle {
        position: absolute;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background-color: #2f80ed;
        border: 2px solid #ffffff;
        touch-action: none;
        pointer-events: auto;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }
    
    @media (max-width: 639px) {
        .crop-handle {
            width: 24px;
            height: 24px;
            border-width: 3px;
        }
    }

    .crop-handle[data-handle="nw"] {
        top: -7px;
        left: -7px;
        cursor: nwse-resize;
    }

    .crop-handle[data-handle="ne"] {
        top: -7px;
        right: -7px;
        cursor: nesw-resize;
    }

    .crop-handle[data-handle="sw"] {
        bottom: -7px;
        left: -7px;
        cursor: nesw-resize;
    }

    .crop-handle[data-handle="se"] {
        bottom: -7px;
        right: -7px;
        cursor: nwse-resize;
    }

    .crop-modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .crop-modal-actions button {
        z-index: 10001;
        position: relative;
    }
    
    .slider {
        -webkit-appearance: none;
        appearance: none;
        background: #e5e7eb;
        outline: none;
        border-radius: 8px;
        height: 8px;
        width: 100%;
    }
    
    @media (max-width: 768px) {
        .slider {
            height: 10px;
        }
        
        .slider::-webkit-slider-thumb {
            width: 24px;
            height: 24px;
        }
        
        .slider::-moz-range-thumb {
            width: 24px;
            height: 24px;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="url"] {
            font-size: 16px !important;
            min-height: 44px;
            padding: 0.75rem 1rem !important;
        }
        
        /* Garantir que o final da página seja visível */
        form#companyForm {
            padding-bottom: 6rem !important;
            margin-bottom: 2rem !important;
        }
        
        .max-w-4xl {
            padding-bottom: 4rem !important;
            margin-bottom: 2rem !important;
        }
        
        /* Última seção precisa de mais espaço */
        .bg-white.rounded-xl.shadow-sm:last-child,
        .dark .bg-gray-800.rounded-xl.shadow-sm:last-child {
            margin-bottom: 3rem !important;
            padding-bottom: 2rem !important;
        }
    }
    
    .slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        background: #8b5cf6;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(139, 92, 246, 0.3);
        transition: all 0.3s ease;
        border: 2px solid #ffffff;
    }
    
    .slider::-webkit-slider-thumb:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
    }
    
    .slider::-moz-range-thumb {
        width: 20px;
        height: 20px;
        background: #8b5cf6;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid #ffffff;
        box-shadow: 0 2px 6px rgba(139, 92, 246, 0.3);
        transition: all 0.3s ease;
    }
    
    .slider::-moz-range-thumb:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
    }
    
    /* Dark mode support */
    .dark .slider {
        background: #374151;
    }
    
    .dark .slider::-webkit-slider-thumb {
        background: #8b5cf6;
        border-color: #1f2937;
    }
    
    .dark .slider::-moz-range-thumb {
        background: #8b5cf6;
        border-color: #1f2937;
    }
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto pb-8 sm:pb-6">
    <form method="POST" action="{{ route('companies.update', $company->id) }}" enctype="multipart/form-data" id="companyForm" class="space-y-4 sm:space-y-6 pb-12 sm:pb-6">
        @csrf
        @method('PUT')

        <!-- Dados Básicos -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">{{ __('companies.basic_info') }}</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('companies.name') }} *</label>
                    <input type="text" name="name" value="{{ old('name', $company->name) }}" placeholder="{{ __('companies.name_placeholder') }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-base" style="font-size: 16px; min-height: 44px;" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('companies.url') }}</label>
                    <input type="text" name="url" value="{{ old('url', $company->url) }}" placeholder="{{ __('companies.url_placeholder') }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-base" style="font-size: 16px; min-height: 44px;">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ __('companies.url_hint') }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('companies.email') }} *</label>
                    <input type="email" name="negative_email" value="{{ old('negative_email', $company->negative_email) }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-base" style="font-size: 16px; min-height: 44px;" required>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('companies.negative_email_desc') }}</p>
                </div>
            </div>
        </div>

        <!-- Upload de Imagens -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">{{ __('companies.visual_customization') }}</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('companies.logo') }}</label>
                    <div class="upload-area rounded-lg p-4 text-center cursor-pointer" id="logoUploadArea">
                        <div id="logoPreviewContainer">
                            @if($company->logo_url)
                                <img src="{{ $company->logo_url }}?t={{ time() }}" alt="{{ __('companies.logo') }}" class="max-w-xs mx-auto mb-2 rounded-lg" id="logoPreviewImg" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                <div id="logoPlaceholder" class="py-4" style="display: none;">
                                    <i class="fas fa-image text-4xl text-gray-400 dark:text-gray-500 mb-2"></i>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('companies.upload_click') }}</p>
                                </div>
                            @else
                                <div id="logoPlaceholder" class="py-4">
                                    <i class="fas fa-image text-4xl text-gray-400 dark:text-gray-500 mb-2"></i>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('companies.upload_click') }}</p>
                                </div>
                            @endif
                        </div>
                        <input type="file" name="logo" accept="image/*" class="hidden" id="logoInput" onchange="handleLogoUpload(this)">
                        <button type="button" onclick="document.getElementById('logoInput').click()" class="text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 mt-2">
                            <i class="fas fa-upload mr-2"></i>{{ __('companies.logo_change') }}
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('companies.background_image') }}</label>
                    <div class="upload-area rounded-lg p-4 text-center cursor-pointer" id="backgroundUploadArea">
                        <div id="backgroundPreviewContainer">
                            @if($company->background_image_url)
                                <img src="{{ $company->background_image_url }}" alt="{{ __('companies.background_image') }}" class="max-w-xs mx-auto mb-2 rounded-lg" id="backgroundPreviewImg">
                            @else
                                <div id="backgroundPlaceholder" class="py-4">
                                    <i class="fas fa-image text-4xl text-gray-400 dark:text-gray-500 mb-2"></i>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('companies.upload_click') }}</p>
                                </div>
                            @endif
                        </div>
                        <input type="file" name="background_image" accept="image/*" class="hidden" id="backgroundInput" onchange="handleBackgroundUpload(this)">
                        <div class="flex gap-2 justify-center mt-2">
                            <button type="button" onclick="document.getElementById('backgroundInput').click()" class="text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300">
                            <i class="fas fa-upload mr-2"></i>{{ __('companies.background_change') }}
                        </button>
                            <button type="button" onclick="openStockImageModal()" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                <i class="fas fa-search mr-2"></i>{{ __('companies.browse_free_images') }}
                        </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações de Contato -->
        {{-- Seção comentada - pode ser reativada no futuro se necessário --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
            {{-- <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">{{ __('companies.company_details') }}</h2> --}}
            
            <div class="space-y-4">
                {{-- Campos comentados - podem ser reativados no futuro se necessário --}}
                {{-- 
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('companies.phone') }}</label>
                    <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $company->contact_number) }}" placeholder="{{ __('companies.phone_placeholder') }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-base" style="font-size: 16px; min-height: 44px;" maxlength="15">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('companies.website') }}</label>
                    <input type="url" name="business_website" value="{{ old('business_website', $company->business_website) }}" placeholder="{{ __('companies.website_placeholder') }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-base" style="font-size: 16px; min-height: 44px;">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('companies.address') }}</label>
                    <input type="text" name="business_address" value="{{ old('business_address', $company->business_address) }}" placeholder="{{ __('companies.address_placeholder') }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-base" style="font-size: 16px; min-height: 44px;">
                </div>
                --}}

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('companies.google_business_url') }}</label>
                    <input type="text" name="google_business_url" value="{{ old('google_business_url', $company->google_business_url) }}" placeholder="{{ __('companies.google_business_url_placeholder') }}" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 text-base" style="font-size: 16px; min-height: 44px;">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('companies.google_business_url_desc') }}</p>
                </div>
            </div>
        </div>

        <!-- Configurações -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-6 mb-16 sm:mb-0" style="margin-bottom: 4rem;">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">{{ __('companies.positive_score') }}</h2>
            
            <div>
                <label for="positive_score" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('companies.positive_score_label') }} *
                </label>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                    <input 
                        type="range" 
                        name="positive_score" 
                        id="positiveScoreSlider"
                        min="1" 
                        max="5" 
                        value="{{ old('positive_score', $company->positive_score ?? 4) }}" 
                        class="flex-1 slider" 
                        style="min-height: 44px;"
                        required
                    >
                    <div class="flex items-center justify-center sm:justify-start space-x-2 min-w-[120px] sm:min-w-[120px]">
                        <span id="positiveScoreValue" class="text-xl sm:text-2xl font-bold text-purple-600 dark:text-purple-400">{{ old('positive_score', $company->positive_score ?? 4) }}</span>
                        <div class="flex text-yellow-400" id="positiveScoreStars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= (old('positive_score', $company->positive_score ?? 4)))
                                    <i class="fas fa-star text-sm sm:text-base"></i>
                                @else
                                    <i class="far fa-star text-sm sm:text-base"></i>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-2">
                    <span>{{ __('companies.very_restrictive') }} (1)</span>
                    <span>{{ __('companies.very_permissive') }} (5)</span>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 mb-4">
                    <i class="fas fa-info-circle mr-1"></i>
                    {{ __('companies.positive_score_desc') }}
                </p>
            </div>
        </div>
        
        <!-- Espaçamento adicional para mobile -->
        <div class="h-12 sm:h-0"></div>
    </form>
</div>

    <!-- Stock Image Search Modal -->
    <div id="stockImageModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center" style="display: none;">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col m-4">
            <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ __('companies.browse_free_images') }}</h3>
                    <button onclick="closeStockImageModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                <div class="flex gap-2">
                    <input type="text" id="stockImageSearch" placeholder="{{ __('companies.search_images_placeholder') }}" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    <button onclick="searchStockImages()" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        <i class="fas fa-search mr-2"></i>{{ __('companies.search') }}
                    </button>
                </div>
            </div>
            <div id="stockImagesGrid" class="flex-1 overflow-y-auto p-4 sm:p-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                <div class="col-span-full text-center text-gray-500 dark:text-gray-400 py-8">
                    <i class="fas fa-image text-4xl mb-2"></i>
                    <p>{{ __('companies.search_images_hint') }}</p>
                </div>
            </div>
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                    {{ __('companies.images_provided_by') }} <a href="https://loremflickr.com" target="_blank" class="text-blue-600 hover:underline">LoremFlickr</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Crop Modal -->
    <div id="cropModal">
    <div class="crop-modal-content">
        <div class="crop-modal-header">
            <h3>{{ __('companies.crop_logo') }}</h3>
            <p>{{ __('companies.crop_logo_desc') }}</p>
        </div>
            <div id="cropImageContainer">
                <img id="cropperImage" src="" alt="Crop">
                <div id="cropOverlay" class="crop-overlay">
                    <div id="cropBox">
                        <span class="crop-handle" data-handle="nw"></span>
                        <span class="crop-handle" data-handle="ne"></span>
                        <span class="crop-handle" data-handle="sw"></span>
                        <span class="crop-handle" data-handle="se"></span>
                    </div>
                </div>
            </div>
        <div class="crop-modal-actions">
            <button type="button" id="cancelCropBtn" class="px-6 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 cursor-pointer font-medium shadow-sm hover:shadow" style="z-index: 10001; position: relative; min-width: 120px;">
                <i class="fas fa-times mr-2"></i>
                {{ __('companies.cancel') }}
            </button>
            <button type="button" id="applyCropBtn" class="px-6 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-all duration-200 cursor-pointer font-medium shadow-md hover:shadow-lg" style="z-index: 10001; position: relative; min-width: 120px;">
                <i class="fas fa-check mr-2"></i>
                {{ __('companies.apply_crop') }}
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
        const cropElements = {
            modal: null,
            container: null,
            image: null,
            overlay: null,
            box: null
        };

        const cropState = {
            originalImage: null,
            naturalWidth: 0,
            naturalHeight: 0,
            imageRect: null,
            cropBox: { x: 0, y: 0, size: 0 },
            ratios: null,
            isDragging: false,
            mode: null,
            handle: null,
            startX: 0,
            startY: 0,
            startCrop: null,
            fileName: 'logo.png'
        };

        function ensureCropElements() {
            if (!cropElements.modal) {
                cropElements.modal = document.getElementById('cropModal');
                cropElements.container = document.getElementById('cropImageContainer');
                cropElements.image = document.getElementById('cropperImage');
                cropElements.overlay = document.getElementById('cropOverlay');
                cropElements.box = document.getElementById('cropBox');
            }
        }

document.addEventListener('DOMContentLoaded', function() {
            ensureCropElements();

            if (cropElements.box) {
                cropElements.box.addEventListener('pointerdown', startCropInteraction);
            }

            const applyBtn = document.getElementById('applyCropBtn');
            if (applyBtn) applyBtn.addEventListener('click', applyCrop);
            const cancelBtn = document.getElementById('cancelCropBtn');
            if (cancelBtn) cancelBtn.addEventListener('click', () => cancelCrop());

            window.addEventListener('resize', handleResizeWhileOpen);

    const slider = document.getElementById('positiveScoreSlider');
    const valueDisplay = document.getElementById('positiveScoreValue');
    const starsContainer = document.getElementById('positiveScoreStars');
    
    if (slider && valueDisplay && starsContainer) {
                const renderStars = (value) => {
            valueDisplay.textContent = value;
            starsContainer.innerHTML = '';
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('i');
                        star.className = i <= value ? 'fas fa-star text-yellow-400' : 'far fa-star text-yellow-400';
                starsContainer.appendChild(star);
            }
                };
        
        slider.addEventListener('input', function() {
                    renderStars(this.value);
        });
        
                renderStars(slider.value);
    }
    
            // Código comentado - referente ao campo de telefone que foi desabilitado
            // Pode ser reativado no futuro se necessário
            /*
    const phoneInput = document.getElementById('contact_number');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) {
                        value = value.slice(0, 11);
            }
            
            if (value.length > 10) {
                        e.target.value = `(${value.slice(0, 2)}) ${value.slice(2, 7)}-${value.slice(7)}`;
            } else if (value.length > 6) {
                        e.target.value = `(${value.slice(0, 2)}) ${value.slice(2, 6)}-${value.slice(6)}`;
            } else if (value.length > 2) {
                        e.target.value = `(${value.slice(0, 2)}) ${value.slice(2)}`;
            } else if (value.length > 0) {
                        e.target.value = `(${value}`;
            }
        });
    }
            */
        });

        function handleLogoUpload(input) {
            ensureCropElements();
            const file = input.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                alert('Por favor, selecione uma imagem válida.');
                input.value = '';
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                alert('A imagem é muito grande. Por favor, selecione uma imagem menor que 5MB.');
                input.value = '';
                return;
            }

            cropState.fileName = file.name ? `${file.name.replace(/\.[^/.]+$/, '') || 'logo'}.png` : 'logo.png';
            cropState.originalImage = new Image();

            const reader = new FileReader();
            reader.onload = function(event) {
                cropState.originalImage.onload = function() {
                    cropState.naturalWidth = cropState.originalImage.naturalWidth;
                    cropState.naturalHeight = cropState.originalImage.naturalHeight;
                    cropState.ratios = null;
                    showCropModal(event.target.result);
                };
                cropState.originalImage.onerror = function() {
                    alert('Erro ao carregar a imagem. Tente novamente.');
                };
                cropState.originalImage.src = event.target.result;
            };
            reader.onerror = function() {
                alert('Erro ao ler o arquivo. Tente novamente.');
            };
            reader.readAsDataURL(file);
        }

        function showCropModal(imageSrc) {
            ensureCropElements();
            if (!cropElements.image || !cropElements.modal) {
                console.error('Crop elements not found:', {
                    image: !!cropElements.image,
                    modal: !!cropElements.modal
                });
                return;
            }

            console.log('Showing crop modal with image:', imageSrc.substring(0, 50) + '...');
            
            // Clear previous event handlers
            cropElements.image.onload = null;
            cropElements.image.onerror = null;
            
            let imageLoaded = false;
            
            cropElements.image.onload = function() {
                if (imageLoaded) return; // Prevent multiple calls
                imageLoaded = true;
                console.log('Image loaded in modal');
                cropElements.image.onerror = null; // Remove error handler after successful load
                prepareCropUI();
            };
            
            cropElements.image.onerror = function() {
                if (imageLoaded) return; // Don't show error if already loaded
                console.error('Error loading image in modal');
                alert('Erro ao carregar a imagem no modal. Tente novamente.');
            };
            
            cropElements.image.src = imageSrc;
            cropElements.image.style.display = 'block';
            cropElements.image.style.visibility = 'visible';
            cropElements.image.style.opacity = '1';
            cropElements.modal.classList.add('show');

            // If image is already loaded (cached), trigger onload manually
            if (cropElements.image.complete && cropElements.image.naturalWidth > 0) {
                console.log('Image already complete, preparing UI');
                if (cropElements.image.onload) {
                    cropElements.image.onload();
                } else {
                    prepareCropUI();
                }
            }
        }

        function prepareCropUI() {
            ensureCropElements();
            if (!cropElements.image || !cropElements.container) {
                console.error('Missing crop elements in prepareCropUI');
                return;
            }
            
            // Ensure image is visible
            cropElements.image.style.display = 'block';
            cropElements.image.style.visibility = 'visible';
            cropElements.image.style.opacity = '1';
            
            if (!cropElements.image.complete || cropElements.image.naturalWidth === 0) {
                console.log('Image not complete yet, retrying...');
                setTimeout(prepareCropUI, 50);
                return;
            }

            console.log('Preparing crop UI, image dimensions:', cropElements.image.naturalWidth, 'x', cropElements.image.naturalHeight);
            
            updateImageRect();

            if (!cropState.imageRect || !cropState.imageRect.width || !cropState.imageRect.height) {
                console.log('Image rect not ready, retrying...');
                setTimeout(prepareCropUI, 50);
                return;
            }

            cropElements.overlay.classList.add('active');
            cropElements.box.classList.add('active');

            if (cropState.ratios) {
                applyRatiosToCropBox();
            } else {
                initializeCropBox();
            }

            updateCropBoxPosition();
            console.log('Crop UI prepared successfully');
        }

        function updateImageRect() {
            ensureCropElements();
            if (!cropElements.container || !cropElements.image) return;

            const containerRect = cropElements.container.getBoundingClientRect();
            const imageRect = cropElements.image.getBoundingClientRect();

            cropState.imageRect = {
                left: imageRect.left - containerRect.left,
                top: imageRect.top - containerRect.top,
                width: imageRect.width,
                height: imageRect.height
            };
        }

        function initializeCropBox() {
            if (!cropState.imageRect) return;
            const { left, top, width, height } = cropState.imageRect;
            const baseSize = Math.min(width, height) * 0.65;
            cropState.cropBox = {
                x: left + (width - baseSize) / 2,
                y: top + (height - baseSize) / 2,
                size: baseSize
            };
        }

        function applyRatiosToCropBox() {
            if (!cropState.ratios || !cropState.imageRect) {
                initializeCropBox();
                return;
            }

            const { left, top, width, height } = cropState.imageRect;
            const minDimension = Math.min(width, height);
            const desiredSize = cropState.ratios.size * minDimension;
            const minSize = Math.max(60, minDimension * 0.15);
            const size = clamp(desiredSize, minSize, minDimension);
            let x = left + cropState.ratios.x * width;
            let y = top + cropState.ratios.y * height;

            x = clamp(x, left, left + width - size);
            y = clamp(y, top, top + height - size);

            cropState.cropBox = { x, y, size };
        }

        function updateCropBoxPosition() {
            ensureCropElements();
            if (!cropElements.box || !cropState.imageRect) return;
            const { x, y, size } = cropState.cropBox;
            cropElements.box.style.left = `${x}px`;
            cropElements.box.style.top = `${y}px`;
            cropElements.box.style.width = `${size}px`;
            cropElements.box.style.height = `${size}px`;
            cropElements.overlay.classList.add('active');
            cropElements.box.classList.add('active');
            updateRatios();
        }

        function updateRatios() {
            if (!cropState.imageRect) return;
            const { left, top, width, height } = cropState.imageRect;
            const { x, y, size } = cropState.cropBox;
            const minDimension = Math.min(width, height);

            cropState.ratios = {
                x: (x - left) / width,
                y: (y - top) / height,
                size: size / minDimension
            };
        }

        function startCropInteraction(event) {
            ensureCropElements();
            if (!cropState.imageRect) return;

            event.preventDefault();
            const handle = event.target.dataset.handle || null;
            cropState.mode = handle ? 'resize' : 'move';
            cropState.handle = handle;
            cropState.isDragging = true;
            cropState.startX = event.clientX;
            cropState.startY = event.clientY;
            cropState.startCrop = { ...cropState.cropBox };

            window.addEventListener('pointermove', onCropPointerMove);
            window.addEventListener('pointerup', endCropInteraction);
        }

        function onCropPointerMove(event) {
            if (!cropState.isDragging) return;
            event.preventDefault();
            const dx = event.clientX - cropState.startX;
            const dy = event.clientY - cropState.startY;

            if (cropState.mode === 'move') {
                moveCropBox(dx, dy);
            } else {
                resizeCropBox(dx, dy);
            }

            updateCropBoxPosition();
        }

        function endCropInteraction() {
            cropState.isDragging = false;
            window.removeEventListener('pointermove', onCropPointerMove);
            window.removeEventListener('pointerup', endCropInteraction);
        }

        function moveCropBox(dx, dy) {
            const limits = getLimits();
            const size = cropState.startCrop.size;
            const maxX = limits.right - size;
            const maxY = limits.bottom - size;

            cropState.cropBox.x = clamp(cropState.startCrop.x + dx, limits.left, maxX);
            cropState.cropBox.y = clamp(cropState.startCrop.y + dy, limits.top, maxY);
            cropState.cropBox.size = size;
        }

        function resizeCropBox(dx, dy) {
            const limits = getLimits();
            const minDimension = Math.min(cropState.imageRect.width, cropState.imageRect.height);
            const minSize = Math.max(60, minDimension * 0.15);
            const start = cropState.startCrop;
            const startRight = start.x + start.size;
            const startBottom = start.y + start.size;
            let newSize = start.size;
            let newX = start.x;
            let newY = start.y;

            switch (cropState.handle) {
                case 'nw': {
                    const newLeft = clamp(start.x + dx, limits.left, startRight - minSize);
                    const newTop = clamp(start.y + dy, limits.top, startBottom - minSize);
                    const diff = Math.min(startRight - newLeft, startBottom - newTop);
                    const maxSize = Math.min(startRight - limits.left, startBottom - limits.top);
                    newSize = clamp(diff, minSize, maxSize);
                    newX = startRight - newSize;
                    newY = startBottom - newSize;
                    break;
                }
                case 'ne': {
                    const newRight = clamp(startRight + dx, start.x + minSize, limits.right);
                    const newTop = clamp(start.y + dy, limits.top, startBottom - minSize);
                    const diff = Math.min(newRight - start.x, startBottom - newTop);
                    const maxSize = Math.min(limits.right - start.x, startBottom - limits.top);
                    newSize = clamp(diff, minSize, maxSize);
                    newX = start.x;
                    newY = startBottom - newSize;
                    break;
                }
                case 'sw': {
                    const newLeft = clamp(start.x + dx, limits.left, startRight - minSize);
                    const newBottom = clamp(startBottom + dy, start.y + minSize, limits.bottom);
                    const diff = Math.min(startRight - newLeft, newBottom - start.y);
                    const maxSize = Math.min(startRight - limits.left, limits.bottom - start.y);
                    newSize = clamp(diff, minSize, maxSize);
                    newX = startRight - newSize;
                    newY = start.y;
                    break;
                }
                case 'se':
                default: {
                    const newRight = clamp(startRight + dx, start.x + minSize, limits.right);
                    const newBottom = clamp(startBottom + dy, start.y + minSize, limits.bottom);
                    const diff = Math.min(newRight - start.x, newBottom - start.y);
                    const maxSize = Math.min(limits.right - start.x, limits.bottom - start.y);
                    newSize = clamp(diff, minSize, maxSize);
                    newX = start.x;
                    newY = start.y;
                    break;
                }
            }

            const maxX = limits.right - newSize;
            const maxY = limits.bottom - newSize;
            cropState.cropBox.x = clamp(newX, limits.left, maxX);
            cropState.cropBox.y = clamp(newY, limits.top, maxY);
            cropState.cropBox.size = newSize;
        }

        function getLimits() {
            if (!cropState.imageRect) {
                return { left: 0, top: 0, right: 0, bottom: 0 };
            }
            const { left, top, width, height } = cropState.imageRect;
            return {
                left,
                top,
                right: left + width,
                bottom: top + height
            };
        }

        function handleResizeWhileOpen() {
            ensureCropElements();
            if (!cropElements.modal || !cropElements.modal.classList.contains('show')) return;
            if (!cropElements.image || !cropElements.image.src) return;

            updateImageRect();
            if (!cropState.imageRect) return;

            if (cropState.ratios) {
                applyRatiosToCropBox();
            } else {
                initializeCropBox();
            }

            updateCropBoxPosition();
        }

        function applyCrop() {
            ensureCropElements();
            if (!cropState.originalImage || !cropState.imageRect) {
                alert('Carregue uma imagem para recortar.');
                return;
            }

            const { left, top, width, height } = cropState.imageRect;
            const { x, y, size } = cropState.cropBox;
            const relativeX = x - left;
            const relativeY = y - top;
            const scaleX = cropState.naturalWidth / width;
            const scaleY = cropState.naturalHeight / height;
            let sourceX = relativeX * scaleX;
            let sourceY = relativeY * scaleY;
            let sourceSize = size * scaleX;

            sourceX = clamp(sourceX, 0, cropState.naturalWidth - 1);
            sourceY = clamp(sourceY, 0, cropState.naturalHeight - 1);
            const maxSize = Math.min(sourceSize, cropState.naturalWidth - sourceX, cropState.naturalHeight - sourceY);
            sourceSize = Math.max(1, maxSize);

            const canvasSize = 800;
            const canvas = document.createElement('canvas');
            canvas.width = canvasSize;
            canvas.height = canvasSize;
            const ctx = canvas.getContext('2d');
            ctx.imageSmoothingEnabled = true;
            ctx.imageSmoothingQuality = 'high';
            ctx.drawImage(
                cropState.originalImage,
                sourceX,
                sourceY,
                sourceSize,
                sourceSize,
                0,
                0,
                canvasSize,
                canvasSize
            );

            canvas.toBlob(function(blob) {
                if (!blob) {
                    alert('Erro ao processar a imagem. Tente novamente.');
                    return;
                }

                const file = new File([blob], cropState.fileName, { type: 'image/png' });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);

                const logoInput = document.getElementById('logoInput');
                if (logoInput) {
                    logoInput.files = dataTransfer.files;
                    console.log('File added to input:', {
                        fileName: file.name,
                        fileSize: file.size,
                        fileType: file.type,
                        inputFilesLength: logoInput.files.length
                    });
                    
                    // Trigger change event to ensure form recognizes the file
                    const changeEvent = new Event('change', { bubbles: true });
                    logoInput.dispatchEvent(changeEvent);
                } else {
                    console.error('logoInput not found!');
                }

                const base64Data = canvas.toDataURL('image/png');
                const logoPreviewContainer = document.getElementById('logoPreviewContainer');
                const logoPreviewImg = document.getElementById('logoPreviewImg');
                const logoPlaceholder = document.getElementById('logoPlaceholder');

                // Hide placeholder if exists
                if (logoPlaceholder) {
                    logoPlaceholder.style.display = 'none';
                }

                // Update or create preview image
                if (logoPreviewImg) {
                    logoPreviewImg.src = base64Data;
                    logoPreviewImg.style.display = 'block';
                } else if (logoPreviewContainer) {
                    // Create preview image if it doesn't exist
                    const newImg = document.createElement('img');
                    newImg.id = 'logoPreviewImg';
                    newImg.src = base64Data;
                    newImg.alt = '{{ __('companies.logo') }}';
                    newImg.className = 'max-w-xs mx-auto mb-2 rounded-lg';
                    logoPreviewContainer.insertBefore(newImg, logoPreviewContainer.firstChild);
                }

                cancelCrop(false);
            }, 'image/png', 0.92);
        }

        function cancelCrop(resetInput = true) {
            ensureCropElements();
            endCropInteraction();

            if (cropElements.modal) {
                cropElements.modal.classList.remove('show');
            }
            if (cropElements.overlay) {
                cropElements.overlay.classList.remove('active');
            }
            if (cropElements.box) {
                cropElements.box.classList.remove('active');
                cropElements.box.style.width = '';
                cropElements.box.style.height = '';
                cropElements.box.style.left = '';
                cropElements.box.style.top = '';
            }
            if (cropElements.image) {
                cropElements.image.style.display = 'none';
                cropElements.image.src = '';
            }

            cropState.originalImage = null;
            cropState.imageRect = null;
            cropState.cropBox = { x: 0, y: 0, size: 0 };
            cropState.ratios = null;
            cropState.isDragging = false;

            if (resetInput) {
                const logoInput = document.getElementById('logoInput');
                if (logoInput) {
                    logoInput.value = '';
                }
            }
        }

        function clamp(value, min, max) {
            return Math.min(Math.max(value, min), max);
        }

function saveForm() {
    const form = document.getElementById('companyForm');
    if (!form) {
        console.error('{{ __('companies.form_not_found') }}');
        showNotification('{{ __('companies.error_form_not_found') }}', 'error');
        return;
    }
    
    // Verificar se há arquivo no input de logo antes de submeter
    const logoInput = document.getElementById('logoInput');
    if (logoInput && logoInput.files && logoInput.files.length > 0) {
        console.log('Logo file ready for submission:', {
            fileName: logoInput.files[0].name,
            fileSize: logoInput.files[0].size,
            fileType: logoInput.files[0].type
        });
    } else {
        console.log('No logo file in input');
    }
    
    // Remove any existing save_as_draft input
    const existingDraftInput = form.querySelector('input[name="save_as_draft"]');
    if (existingDraftInput) {
        existingDraftInput.remove();
    }
    
    // Add save_as_draft input with value 'true'
    const draftInput = document.createElement('input');
    draftInput.type = 'hidden';
    draftInput.name = 'save_as_draft';
    draftInput.value = 'true';
    form.appendChild(draftInput);
    
    const saveBtn = document.querySelector('button[onclick="saveForm()"]');
    const submitBtn = document.querySelector('button[onclick="submitForm()"]');
    if (saveBtn && !saveBtn.dataset.originalText) {
        saveBtn.dataset.originalText = saveBtn.innerHTML;
    }
    if (saveBtn) {
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> {{ __('companies.saving') }}';
        saveBtn.disabled = true;
    }
    if (submitBtn) {
        submitBtn.disabled = true;
    }
    
    // Submit form (with save_as_draft = true, so it will be saved as draft)
    form.submit();
}

function submitForm() {
    const form = document.getElementById('companyForm');
    if (!form) return;
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    
    // Remove any existing save_as_draft input (to ensure it's published)
    const existingDraftInput = form.querySelector('input[name="save_as_draft"]');
    if (existingDraftInput) {
        existingDraftInput.remove();
    }
    
    const submitBtn = document.querySelector('button[onclick="submitForm()"]');
    const saveBtn = document.querySelector('button[onclick="saveForm()"]');
    if (submitBtn && !submitBtn.dataset.originalText) {
        submitBtn.dataset.originalText = submitBtn.innerHTML;
    }
    if (submitBtn) {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> {{ __('companies.activating') }}';
        submitBtn.disabled = true;
    }
    if (saveBtn) {
        saveBtn.disabled = true;
    }
    
    // Submit form (without save_as_draft, so it will be published)
    form.submit();
}

function showNotification(message, type) {
    alert(message);
}

function handleBackgroundUpload(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewContainer = document.getElementById('backgroundPreviewContainer');
            const placeholder = document.getElementById('backgroundPlaceholder');
            
            if (placeholder) {
                placeholder.remove();
            }
            
            let previewImg = document.getElementById('backgroundPreviewImg');
                    if (!previewImg && previewContainer) {
                previewImg = document.createElement('img');
                previewImg.id = 'backgroundPreviewImg';
                previewImg.className = 'max-w-xs mx-auto mb-2 rounded-lg';
                previewImg.alt = '{{ __('companies.background_image') }}';
                previewContainer.appendChild(previewImg);
            }
            
                    if (previewImg) {
            previewImg.src = e.target.result;
                    }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

        document.querySelectorAll('.upload-area').forEach(area => {
            area.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            area.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            area.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const input = this.querySelector('input[type="file"]');
                    if (input) {
                        input.files = files;
                        if (input.id === 'logoInput') {
                            handleLogoUpload(input);
                        } else if (input.id === 'backgroundInput') {
                            handleBackgroundUpload(input);
                        }
                    }
                }
            });
        });

        // Stock Image Search Functions
        function openStockImageModal() {
            const modal = document.getElementById('stockImageModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            // Load popular images on open
            searchStockImages('business');
        }

        function closeStockImageModal() {
            const modal = document.getElementById('stockImageModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }

        async function searchStockImages(query = 'business') {
            const searchInput = document.getElementById('stockImageSearch');
            const searchTerm = searchInput ? searchInput.value.trim() || query : query;
            const grid = document.getElementById('stockImagesGrid');
            
            if (!grid) return;
            
            grid.innerHTML = '<div class="col-span-full text-center py-8"><i class="fas fa-spinner fa-spin text-2xl text-purple-600"></i><p class="mt-2">{{ __('companies.loading_images') }}</p></div>';
            
            // Using LoremFlickr directly - no CORS issues and deterministic with lock parameter
            loadStockImagesFromDirectUrls(searchTerm);
        }

        function loadStockImagesFromDirectUrls(searchTerm) {
            const grid = document.getElementById('stockImagesGrid');
            if (!grid) return;

            grid.innerHTML = '';

            const images = [];
            const baseSeed = Date.now();
            const termRaw = searchTerm && searchTerm.trim() ? searchTerm.trim() : 'business';
            const sanitizedTerm = termRaw.toLowerCase()
                .replace(/[^a-z0-9\s,]/g, ' ')
                .trim()
                .replace(/\s+/g, ',') || 'business';

            for (let i = 1; i <= 20; i++) {
                const lock = baseSeed + i;
                images.push({
                    seed: lock,
                    term: sanitizedTerm,
                    displayTerm: termRaw,
                    thumbUrl: `https://loremflickr.com/400/300/${sanitizedTerm}?lock=${lock}`
                });
            }

            displayStockImages(images);
        }

        function displayStockImages(images) {
            const grid = document.getElementById('stockImagesGrid');
            if (!grid) return;

            if (!images || images.length === 0) {
                grid.innerHTML = '<div class="col-span-full text-center text-gray-500 dark:text-gray-400 py-8"><i class="fas fa-image text-4xl mb-2"></i><p>{{ __('companies.no_images_found') }}</p></div>';
                return;
            }

            grid.innerHTML = images.map(image => `
                <div class="relative group cursor-pointer" onclick="selectStockImage('${image.seed}', '${image.term}')">
                    <div class="aspect-video bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden">
                        <img src="${image.thumbUrl}" alt="${image.displayTerm || 'Stock image'}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" loading="lazy" onerror="this.parentElement.innerHTML='<div class=\\'w-full h-full flex items-center justify-center text-gray-400\\'><i class=\\'fas fa-image text-2xl\\'></i></div>'">
                    </div>
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-opacity rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity"></i>
                    </div>
                </div>
            `).join('');
        }

        async function selectStockImage(seed, term) {
            try {
                const grid = document.getElementById('stockImagesGrid');
                if (grid) {
                    grid.innerHTML = '<div class="col-span-full text-center py-8"><i class="fas fa-spinner fa-spin text-2xl text-purple-600"></i><p class="mt-2">{{ __('companies.downloading_image') }}</p></div>';
                }

                const fetchUrl = `https://loremflickr.com/1920/1080/${term}?lock=${seed}`;

                let response = await fetch(fetchUrl, { mode: 'cors' });

                if (!response.ok) {
                    const proxyUrl = `https://api.allorigins.win/raw?url=${encodeURIComponent(fetchUrl)}`;
                    response = await fetch(proxyUrl);
                }

                const blob = await response.blob();
                const file = new File([blob], `stock-${seed}.jpg`, { type: 'image/jpeg' });

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);

                const backgroundInput = document.getElementById('backgroundInput');
                if (backgroundInput) {
                    backgroundInput.files = dataTransfer.files;

                    const changeEvent = new Event('change', { bubbles: true });
                    backgroundInput.dispatchEvent(changeEvent);

        const reader = new FileReader();
        reader.onload = function(e) {
                        const previewImg = document.getElementById('backgroundPreviewImg');
            const placeholder = document.getElementById('backgroundPlaceholder');
                        const previewContainer = document.getElementById('backgroundPreviewContainer');

                        if (!previewImg && previewContainer) {
                            const img = document.createElement('img');
                            img.id = 'backgroundPreviewImg';
                            img.src = e.target.result;
                            img.alt = '{{ __('companies.background_image') }}';
                            img.className = 'max-w-xs mx-auto mb-2 rounded-lg';
                            previewContainer.innerHTML = '';
                            previewContainer.appendChild(img);
                        } else if (previewImg) {
                            previewImg.src = e.target.result;
                        }

            if (placeholder) {
                            placeholder.style.display = 'none';
                        }
                    };
                    reader.readAsDataURL(file);
                }

                closeStockImageModal();
            } catch (error) {
                console.error('Error selecting image:', error);
                alert('{{ __('companies.error_downloading_image') }}');
            }
        }

        // Allow Enter key to search
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('stockImageSearch');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        searchStockImages();
                    }
                });
            }
        });
</script>
@endsection
