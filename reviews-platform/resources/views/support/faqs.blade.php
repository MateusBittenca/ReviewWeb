@extends('layouts.admin')

@section('title', __('support.faqs_title'))
@section('page-title', __('support.faqs_title'))
@section('page-description', __('support.faqs_description'))

@section('styles')
<style>
    .faq-item {
        transition: all 0.3s ease;
    }
    
    .faq-question {
        cursor: pointer;
        user-select: none;
    }
    
    .faq-question:hover {
        background-color: rgba(139, 92, 246, 0.05);
    }
    
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, padding 0.3s ease;
    }
    
    .faq-item.active .faq-answer {
        max-height: 500px;
        padding-top: 1rem;
    }
    
    .faq-item.active .faq-icon {
        transform: rotate(180deg);
    }
    
    .faq-icon {
        transition: transform 0.3s ease;
    }
    
    .category-card {
        transition: all 0.3s ease;
    }
    
    .category-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
    
    .category-card.active {
        border-color: #8b5cf6;
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.05) 0%, rgba(139, 92, 246, 0.1) 100%);
    }
</style>
@endsection

@section('content')
<div class="fade-in">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 rounded-xl border border-purple-200 dark:border-purple-800 p-8 mb-8">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-16 h-16 bg-purple-500 rounded-xl flex items-center justify-center">
                <i class="fas fa-question-circle text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ __('support.faqs_title') }}</h1>
                <p class="text-gray-700 dark:text-gray-300">{{ __('support.faqs_description') }}</p>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="relative">
            <input 
                type="text" 
                id="faqSearch" 
                placeholder="{{ __('support.search_placeholder') }}"
                class="w-full px-4 py-3 pl-12 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
            >
            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
    </div>

    <!-- Category Filters -->
    <div class="mb-8">
        <div class="flex flex-wrap gap-4" id="categoryFilters">
            <button onclick="filterCategory('all')" class="category-filter-btn category-card active bg-white dark:bg-gray-800 border-2 border-purple-500 px-6 py-3 rounded-lg font-medium text-gray-900 dark:text-gray-100 transition-all" data-category="all">
                {{ __('support.view_all') }}
            </button>
            <button onclick="filterCategory('getting-started')" class="category-filter-btn category-card bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 px-6 py-3 rounded-lg font-medium text-gray-900 dark:text-gray-100 transition-all" data-category="getting-started">
                <i class="fas fa-rocket mr-2 text-purple-500"></i>{{ __('support.category_getting_started') }}
            </button>
            <button onclick="filterCategory('managing-reviews')" class="category-filter-btn category-card bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 px-6 py-3 rounded-lg font-medium text-gray-900 dark:text-gray-100 transition-all" data-category="managing-reviews">
                <i class="fas fa-star mr-2 text-yellow-500"></i>{{ __('support.category_managing_reviews') }}
            </button>
            <button onclick="filterCategory('multiple-companies')" class="category-filter-btn category-card bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 px-6 py-3 rounded-lg font-medium text-gray-900 dark:text-gray-100 transition-all" data-category="multiple-companies">
                <i class="fas fa-building mr-2 text-indigo-500"></i>{{ __('support.category_multiple_companies') }}
            </button>
            <button onclick="filterCategory('sharing')" class="category-filter-btn category-card bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 px-6 py-3 rounded-lg font-medium text-gray-900 dark:text-gray-100 transition-all" data-category="sharing">
                <i class="fas fa-share-alt mr-2 text-green-500"></i>{{ __('support.category_sharing') }}
            </button>
            <button onclick="filterCategory('account')" class="category-filter-btn category-card bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 px-6 py-3 rounded-lg font-medium text-gray-900 dark:text-gray-100 transition-all" data-category="account">
                <i class="fas fa-user mr-2 text-blue-500"></i>{{ __('support.category_account') }}
            </button>
            <button onclick="filterCategory('technical')" class="category-filter-btn category-card bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 px-6 py-3 rounded-lg font-medium text-gray-900 dark:text-gray-100 transition-all" data-category="technical">
                <i class="fas fa-tools mr-2 text-red-500"></i>{{ __('support.category_technical') }}
            </button>
        </div>
    </div>

    <!-- FAQs List -->
    <div id="faqsContainer">
        <!-- Getting Started -->
        <div class="faq-category mb-8" data-category="getting-started" id="getting-started">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                <i class="fas fa-rocket text-purple-500 mr-3"></i>
                {{ __('support.category_getting_started') }}
            </h2>
            <div class="space-y-4">
                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_how_create_company') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_how_create_company_answer') }}</p>
                    </div>
                </div>

                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_how_configure_page') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_how_configure_page_answer') }}</p>
                    </div>
                </div>

                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_how_generate_link') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_how_generate_link_answer') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Managing Reviews -->
        <div class="faq-category mb-8" data-category="managing-reviews" id="managing-reviews">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                <i class="fas fa-star text-yellow-500 mr-3"></i>
                {{ __('support.category_managing_reviews') }}
            </h2>
            <div class="space-y-4">
                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_how_view_reviews') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_how_view_reviews_answer') }}</p>
                    </div>
                </div>

                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_what_positive_negative') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_what_positive_negative_answer') }}</p>
                    </div>
                </div>

                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_how_export_contacts') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_how_export_contacts_answer') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Multiple Companies -->
        <div class="faq-category mb-8" data-category="multiple-companies" id="multiple-companies">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                <i class="fas fa-building text-indigo-500 mr-3"></i>
                {{ __('support.category_multiple_companies') }}
            </h2>
            <div class="space-y-4">
                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_can_have_multiple') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_can_have_multiple_answer') }}</p>
                    </div>
                </div>

                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_how_switch_companies') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_how_switch_companies_answer') }}</p>
                    </div>
                </div>

                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_stats_consolidated') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_stats_consolidated_answer') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sharing -->
        <div class="faq-category mb-8" data-category="sharing" id="sharing">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                <i class="fas fa-share-alt text-green-500 mr-3"></i>
                {{ __('support.category_sharing') }}
            </h2>
            <div class="space-y-4">
                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_how_share_link') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_how_share_link_answer') }}</p>
                    </div>
                </div>

                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_link_expires') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_link_expires_answer') }}</p>
                    </div>
                </div>

                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_customize_public_page') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_customize_public_page_answer') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account -->
        <div class="faq-category mb-8" data-category="account" id="account">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                <i class="fas fa-user text-blue-500 mr-3"></i>
                {{ __('support.category_account') }}
            </h2>
            <div class="space-y-4">
                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_how_change_data') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_how_change_data_answer') }}</p>
                    </div>
                </div>

                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_how_change_password') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_how_change_password_answer') }}</p>
                    </div>
                </div>

                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_user_levels') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_user_levels_answer') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Technical -->
        <div class="faq-category mb-8" data-category="technical" id="technical">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                <i class="fas fa-tools text-red-500 mr-3"></i>
                {{ __('support.category_technical') }}
            </h2>
            <div class="space-y-4">
                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_cannot_access') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_cannot_access_answer') }}</p>
                    </div>
                </div>

                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_reviews_not_showing') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_reviews_not_showing_answer') }}</p>
                    </div>
                </div>

                <div class="faq-item bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="faq-question px-6 py-4 flex items-center justify-between" onclick="toggleFaq(this)">
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ __('support.faq_error_create_company') }}</span>
                        <i class="fas fa-chevron-down faq-icon text-purple-500"></i>
                    </div>
                    <div class="faq-answer px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('support.faq_error_create_company_answer') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- No Results -->
    <div id="noResults" class="hidden text-center py-12">
        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-search text-gray-400 text-3xl"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('support.no_results') }}</h3>
        <p class="text-gray-600 dark:text-gray-400">Tente buscar com outras palavras-chave</p>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentCategory = 'all';
    let searchTerm = '';

    function toggleFaq(element) {
        const faqItem = element.closest('.faq-item');
        const isActive = faqItem.classList.contains('active');
        
        // Close all FAQs
        document.querySelectorAll('.faq-item').forEach(item => {
            item.classList.remove('active');
        });
        
        // Open clicked FAQ if it wasn't active
        if (!isActive) {
            faqItem.classList.add('active');
            // Scroll to FAQ if needed
            setTimeout(() => {
                faqItem.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 100);
        }
    }

    function filterCategory(category) {
        currentCategory = category;
        
        // Update active button
        document.querySelectorAll('.category-filter-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.classList.remove('border-purple-500');
            btn.classList.add('border-gray-200', 'dark:border-gray-700');
        });
        
        const activeBtn = document.querySelector(`[data-category="${category}"]`);
        if (activeBtn) {
            activeBtn.classList.add('active', 'border-purple-500');
            activeBtn.classList.remove('border-gray-200', 'dark:border-gray-700');
        }
        
        // Filter FAQs
        applyFilters();
    }

    function applyFilters() {
        const searchLower = searchTerm.toLowerCase();
        let visibleCount = 0;
        
        document.querySelectorAll('.faq-category').forEach(category => {
            const categoryName = category.getAttribute('data-category');
            let categoryVisible = false;
            
            category.querySelectorAll('.faq-item').forEach(item => {
                const question = item.querySelector('.faq-question span').textContent.toLowerCase();
                const answer = item.querySelector('.faq-answer p').textContent.toLowerCase();
                const matchesSearch = !searchTerm || question.includes(searchLower) || answer.includes(searchLower);
                const matchesCategory = currentCategory === 'all' || categoryName === currentCategory;
                
                if (matchesSearch && matchesCategory) {
                    item.style.display = '';
                    categoryVisible = true;
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show/hide category header
            if (categoryVisible) {
                category.style.display = '';
            } else {
                category.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        const noResults = document.getElementById('noResults');
        if (visibleCount === 0) {
            noResults.classList.remove('hidden');
            document.getElementById('faqsContainer').style.display = 'none';
        } else {
            noResults.classList.add('hidden');
            document.getElementById('faqsContainer').style.display = '';
        }
    }

    // Search functionality
    document.getElementById('faqSearch').addEventListener('input', function(e) {
        searchTerm = e.target.value;
        applyFilters();
    });

    // Initialize - check URL hash for category
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash.substring(1);
        if (hash) {
            filterCategory(hash);
            setTimeout(() => {
                const element = document.getElementById(hash);
                if (element) {
                    element.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 300);
        }
    });
</script>
@endsection

