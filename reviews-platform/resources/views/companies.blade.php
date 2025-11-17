@extends('layouts.admin')

@section('title', __('companies.title') . ' - Reviews Platform')

@section('page-title', __('companies.title'))
@section('page-description', __('dashboard.companies_count') . ' • ' . $companies->where('status', 'published')->count() . ' ' . __('companies.count_active') . ' • ' . $companies->where('status', 'draft')->count() . ' ' . __('companies.count_draft'))

@section('header-actions')
    <a href="/companies/create" class="btn-primary text-white px-4 py-2 rounded-lg font-medium">
        <i class="fas fa-plus mr-2"></i>
        {{ __('companies.create') }}
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            @if(session('company_url'))
                <div class="mt-2">
                    <a href="{{ session('company_url') }}" target="_blank" class="text-green-600 hover:underline font-medium">
                        <i class="fas fa-external-link-alt mr-1"></i>
                        Ver página pública
                    </a>
                </div>
            @endif
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 md:p-6 mb-6">
        <h3 class="text-base md:text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">{{ __('companies.filters') }}</h3>
        <form id="filtersForm" method="GET" action="{{ route('companies.index') }}" class="flex flex-col sm:flex-row flex-wrap items-stretch sm:items-center gap-3 sm:gap-4">
            <!-- User Filter (Admin/Proprietario only) -->
            @if(in_array(Auth::user()->role, ['admin', 'proprietario']) && $users && $users->count() > 0)
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('companies.filter_by_user') }}</label>
                <select name="user_id" id="userFilter" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent" style="min-height: 44px;">
                    <option value="">{{ __('companies.all_users') }}</option>
                    @foreach($users as $userOption)
                        <option value="{{ $userOption->id }}" {{ request('user_id') == $userOption->id ? 'selected' : '' }}>
                            {{ $userOption->name }} ({{ $userOption->email }})
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
            
            <!-- Search by Name -->
            <div class="flex-1 min-w-[200px] relative">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('companies.search_company') }}</label>
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        id="searchFilter" 
                        value="{{ request('search') }}"
                        placeholder="{{ __('companies.search_company_placeholder') }}"
                        class="w-full px-3 py-2 pl-10 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        style="font-size: 16px; min-height: 44px; padding-left: 2.75rem;"
                    >
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
            
            <!-- Status Filter -->
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('companies.filter_by_status') }}</label>
                <select name="status" id="statusFilter" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent" style="min-height: 44px;">
                    <option value="all">{{ __('companies.all_statuses') }}</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>{{ __('companies.active') }}</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>{{ __('companies.draft') }}</option>
                </select>
            </div>
            
            <!-- Visibility Filter -->
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('companies.filter_by_visibility') }}</label>
                <select name="visibility" id="visibilityFilter" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent" style="min-height: 44px;">
                    <option value="all">{{ __('companies.all_visibilities') }}</option>
                    <option value="visible" {{ request('visibility') == 'visible' ? 'selected' : '' }}>{{ __('companies.visible') }}</option>
                    <option value="hidden" {{ request('visibility') == 'hidden' ? 'selected' : '' }}>{{ __('companies.hidden') }}</option>
                </select>
            </div>
            
            <!-- Rating Limit Filter -->
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('companies.filter_by_rating_limit') }}</label>
                <select name="rating_limit" id="ratingLimitFilter" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent" style="min-height: 44px;">
                    <option value="all">{{ __('companies.all_ratings') }}</option>
                    <option value="5" {{ request('rating_limit') == '5' ? 'selected' : '' }}>5 estrelas</option>
                    <option value="4" {{ request('rating_limit') == '4' ? 'selected' : '' }}>4 estrelas</option>
                    <option value="3" {{ request('rating_limit') == '3' ? 'selected' : '' }}>3 estrelas</option>
                    <option value="2" {{ request('rating_limit') == '2' ? 'selected' : '' }}>2 estrelas</option>
                    <option value="1" {{ request('rating_limit') == '1' ? 'selected' : '' }}>1 estrela</option>
                </select>
            </div>
            
            <!-- Reviews Filter -->
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('companies.filter_by_reviews') }}</label>
                <select name="reviews_filter" id="reviewsFilter" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent" style="min-height: 44px;">
                    <option value="all">{{ __('companies.all_reviews') }}</option>
                    <option value="with_reviews" {{ request('reviews_filter') == 'with_reviews' ? 'selected' : '' }}>{{ __('companies.with_reviews') }}</option>
                    <option value="without_reviews" {{ request('reviews_filter') == 'without_reviews' ? 'selected' : '' }}>{{ __('companies.without_reviews') }}</option>
                </select>
            </div>
            
            <!-- Period Filter -->
            <div class="flex-1 min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('companies.filter_by_period') }}</label>
                <select name="period" id="periodFilter" class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent" style="min-height: 44px;">
                    <option value="all">{{ __('companies.all_periods') }}</option>
                    <option value="today" {{ request('period') == 'today' ? 'selected' : '' }}>{{ __('companies.today') }}</option>
                    <option value="week" {{ request('period') == 'week' ? 'selected' : '' }}>{{ __('companies.this_week') }}</option>
                    <option value="month" {{ request('period') == 'month' ? 'selected' : '' }}>{{ __('companies.this_month') }}</option>
                </select>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-end space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
                <button type="submit" class="btn-primary text-white px-4 py-2 rounded-lg font-medium w-full sm:w-auto" style="min-height: 44px;">
                    <i class="fas fa-filter mr-2"></i>
                    {{ __('companies.apply') }}
                </button>
                <button type="button" onclick="clearFilters()" class="btn-secondary text-white px-4 py-2 rounded-lg font-medium w-full sm:w-auto" style="min-height: 44px;">
                    <i class="fas fa-times mr-2"></i>
                    {{ __('companies.clear') }}
                </button>
            </div>
        </form>
    </div>

    @if($companies->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @foreach($companies as $company)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 card-hover stagger-item">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            @if($company->logo)
                                <div class="image-placeholder w-12 h-12">
                                    <img src="{{ $company->logo_url }}?v={{ time() }}" 
                                         alt="{{ $company->name }}" 
                                         loading="lazy"
                                         class="w-12 h-12 rounded-lg object-cover"
                                         onload="var parent = this.parentElement; parent.classList.add('loaded'); this.style.opacity = '1'; if(parent.querySelector('.placeholder-shimmer')) parent.querySelector('.placeholder-shimmer').style.display = 'none';"
                                         onerror="console.error('Erro ao carregar imagem:', this.src); this.style.display='none'; var next = this.nextElementSibling; if(next) next.style.display='block';"
                                         style="opacity: 0;">
                                    <div class="placeholder-shimmer"></div>
                                </div>
                            @else
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-building text-purple-600"></i>
                                </div>
                            @endif
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $company->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $company->created_at ? $company->created_at->format('d/m/Y') : '' }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $company->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $company->status === 'published' ? __('companies.active') : __('companies.draft') }}
                            </span>
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $company->is_active ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $company->is_active ? __('companies.visible') : __('companies.hidden') }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-3 mb-4">
                        @if($company->user && (auth()->user()->role === 'admin' || auth()->user()->role === 'proprietario'))
                            <div class="flex items-center text-sm text-gray-600 bg-gray-50 px-3 py-2 rounded-lg">
                                <i class="fas fa-user w-4 mr-2 text-purple-600"></i>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium text-gray-800 truncate">{{ $company->user->name }}</div>
                                    <div class="text-xs text-gray-500 truncate">{{ $company->user->email }}</div>
                                    <div class="text-xs mt-1">
                                        @if($company->user->role === 'proprietario')
                                            <span class="px-1.5 py-0.5 rounded bg-yellow-100 text-yellow-800 text-xs font-medium">Proprietário</span>
                                        @elseif($company->user->role === 'admin')
                                            <span class="px-1.5 py-0.5 rounded bg-purple-100 text-purple-800 text-xs font-medium">Admin</span>
                                        @else
                                            <span class="px-1.5 py-0.5 rounded bg-gray-100 text-gray-800 text-xs font-medium">Usuário</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-envelope w-4 mr-2"></i>
                            <span class="truncate">{{ $company->negative_email }}</span>
                        </div>
                        @if($company->contact_number)
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-phone w-4 mr-2"></i>
                                <span>{{ $company->contact_number }}</span>
                            </div>
                        @endif
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="fas fa-star w-4 mr-2"></i>
                            <span>{{ __('companies.rating_limit', ['score' => $company->positive_score]) }}</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4 py-3 border-t border-b border-gray-100">
                        <div class="flex items-center">
                            <i class="fas fa-file-alt mr-1"></i>
                            <span>{{ $company->review_pages_count }} {{ __('companies.pages') }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-comment mr-1"></i>
                            <span>{{ $company->reviews_count }} {{ __('companies.reviews_count') }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:space-x-2">
                        @if($company->status === 'published')
                            <a href="{{ $company->public_url }}" target="_blank" class="flex-1 bg-blue-50 text-blue-600 px-3 py-2 rounded-lg text-sm font-medium hover:bg-blue-100 transition-colors text-center">
                                <i class="fas fa-external-link-alt mr-1"></i>
                                <span class="hidden sm:inline">{{ __('companies.view_page') }}</span>
                                <span class="sm:hidden">{{ __('companies.view') }}</span>
                            </a>
                        @endif
                        <a href="{{ route('companies.edit', $company->id) }}" class="flex-1 bg-purple-50 text-purple-600 px-3 py-2 rounded-lg text-sm font-medium hover:bg-purple-100 transition-colors text-center">
                            <i class="fas fa-edit mr-1"></i>
                            <span class="hidden sm:inline">{{ __('companies.edit_company') }}</span>
                            <span class="sm:hidden">{{ __('companies.edit') }}</span>
                        </a>
                        <form method="POST" action="{{ route('companies.destroy', $company->id) }}" class="inline sm:flex-shrink-0" onsubmit="return confirm('{{ __('companies.confirm_delete') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full sm:w-auto bg-red-50 text-red-600 px-3 py-2 rounded-lg text-sm font-medium hover:bg-red-100 transition-colors">
                                <i class="fas fa-trash mr-1 sm:mr-0"></i>
                                <span class="sm:hidden">{{ __('companies.delete') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $companies->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-purple-100 rounded-full mb-6">
                <i class="fas fa-building text-purple-600 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ __('companies.no_companies') }}</h3>
            <p class="text-gray-600 mb-6">{{ __('companies.no_companies_desc') }}</p>
            <a href="/companies/create" class="btn-primary text-white px-6 py-3 rounded-lg font-medium inline-flex items-center">
                <i class="fas fa-plus mr-2"></i>
                {{ __('companies.create_first') }}
            </a>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        // Enhanced animations and interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add ripple effect to buttons
            document.querySelectorAll('.btn-primary, .btn-secondary').forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.cssText = `
                        position: absolute;
                        width: ${size}px;
                        height: ${size}px;
                        top: ${y}px;
                        left: ${x}px;
                        background: rgba(255, 255, 255, 0.5);
                        border-radius: 50%;
                        transform: scale(0);
                        animation: ripple 0.6s ease-out;
                        pointer-events: none;
                    `;
                    
                    this.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });
            
            // Add hover parallax effect to cards (disabled to prevent button issues)
            // Parallax effect can interfere with button clicks and hover states
            document.querySelectorAll('.card-hover').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    // Simple hover effect without transforms
                    this.style.transition = 'box-shadow 0.3s ease, transform 0.3s ease';
                });
                
                card.addEventListener('mouseleave', function() {
                    // Ensure transition remains
                    this.style.transition = 'box-shadow 0.3s ease, transform 0.3s ease';
                });
            });
        });
        
        // Clear filters function
        function clearFilters() {
            const form = document.getElementById('filtersForm');
            if (form) {
                // Reset all form fields
                form.querySelectorAll('input[type="text"], select').forEach(field => {
                    if (field.name === 'search') {
                        field.value = '';
                    } else if (field.name) {
                        // For selects, set to 'all' or empty
                        if (field.tagName === 'SELECT') {
                            const allOption = field.querySelector('option[value="all"], option[value=""]');
                            if (allOption) {
                                field.value = allOption.value;
                            }
                        }
                    }
                });
                
                // Submit form to reload page without filters
                window.location.href = '{{ route("companies.index") }}';
            }
        }
        
        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection
