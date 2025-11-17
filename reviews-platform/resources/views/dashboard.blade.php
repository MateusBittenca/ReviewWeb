@extends('layouts.admin')

@section('title', __('dashboard.my_dashboard'))
@section('page-title', __('dashboard.my_dashboard'))
@section('page-description', __('dashboard.overview'))

@section('content')
<div class="fade-in">
    <!-- Alerta de Avaliações Negativas -->
    @if(isset($negativeCount) && $negativeCount > 0)
    <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 fade-in animate-pulse">
        <div class="flex items-center flex-1">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-500 text-xl sm:text-2xl mr-3 sm:mr-4"></i>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-semibold text-red-800 dark:text-red-300">
                    {{ __('dashboard.attention_required') }}
                </h3>
                <p class="text-sm sm:text-base text-red-600 dark:text-red-400">
                    {{ __('dashboard.negative_reviews_pending', ['count' => $negativeCount]) }}
                </p>
            </div>
        </div>
        <div class="w-full sm:w-auto">
            <a href="/reviews?filter=negative" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center w-full sm:w-auto">
                <i class="fas fa-eye mr-2"></i>
                {{ __('dashboard.view_negative_reviews') }}
            </a>
        </div>
    </div>
    @endif

    <!-- Admin Overview Card -->
    <div class="bg-gradient-to-r from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 rounded-xl border border-purple-200 dark:border-purple-800 shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-user-shield text-white text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('dashboard.admin_dashboard') }}</h2>
                    <p class="text-gray-600 dark:text-gray-400">{{ isset($allCompanies) ? $allCompanies->count() : 0 }} {{ __('dashboard.registered_companies') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-4 py-2 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 rounded-lg font-semibold">
                    <i class="fas fa-chart-pie mr-1"></i> {{ __('dashboard.overview_badge') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 md:gap-6 mb-6">
        <!-- Total Reviews -->
        <div id="adminStatCardTotal" onclick="filterAdminReviews('all')" class="bg-white dark:bg-gray-800 rounded-xl border-2 border-gray-200 dark:border-gray-700 p-6 card-hover cursor-pointer transition-all hover:shadow-lg hover:border-purple-500 relative group" style="cursor: pointer;" title="👆 Clique para ver todas as avaliações">
            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                <span class="text-xs bg-purple-500 text-white px-2 py-1 rounded-full font-medium">
                    <i class="fas fa-hand-pointer mr-1"></i>Clique
                </span>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">{{ __('dashboard.total_reviews_full') }}</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ isset($stats) ? $stats['total_reviews'] : 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-comment-alt text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Positive Reviews -->
        <div id="adminStatCardPositive" onclick="filterAdminReviews('positive')" class="bg-white dark:bg-gray-800 rounded-xl border-2 border-gray-200 dark:border-gray-700 p-6 card-hover cursor-pointer transition-all hover:shadow-lg hover:border-green-500 relative group" style="cursor: pointer;" title="👆 Clique para ver apenas avaliações positivas">
            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                <span class="text-xs bg-green-500 text-white px-2 py-1 rounded-full font-medium">
                    <i class="fas fa-hand-pointer mr-1"></i>Clique
                </span>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">{{ __('dashboard.positive_reviews_full') }}</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ isset($stats) ? $stats['positive_reviews'] : 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-smile text-green-600 dark:text-green-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Negative Reviews -->
        <div id="adminStatCardNegative" onclick="filterAdminReviews('negative')" class="bg-white dark:bg-gray-800 rounded-xl border-2 border-gray-200 dark:border-gray-700 p-6 card-hover cursor-pointer transition-all hover:shadow-lg hover:border-red-500 relative group" style="cursor: pointer;" title="👆 Clique para ver apenas avaliações negativas">
            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                <span class="text-xs bg-red-500 text-white px-2 py-1 rounded-full font-medium">
                    <i class="fas fa-hand-pointer mr-1"></i>Clique
                </span>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">{{ __('dashboard.negative_reviews_full') }}</p>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ isset($stats) ? $stats['negative_reviews'] : 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-frown text-red-600 dark:text-red-400 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Average Rating -->
        <div id="adminStatCardAverage" onclick="scrollToRecentReviews()" class="bg-white dark:bg-gray-800 rounded-xl border-2 border-gray-200 dark:border-gray-700 p-6 card-hover cursor-pointer transition-all hover:shadow-lg hover:border-blue-500 relative group" style="cursor: pointer;" title="👆 Clique para ver as avaliações recentes">
            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                <span class="text-xs bg-blue-500 text-white px-2 py-1 rounded-full font-medium">
                    <i class="fas fa-hand-pointer mr-1"></i>Clique
                </span>
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">{{ __('dashboard.average_rating_full') }}</p>
                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ isset($stats) ? $stats['average_rating'] : 0 }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reviews -->
    <div id="recentReviewsSection" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                <i class="fas fa-history mr-2"></i>
                {{ __('dashboard.recent_reviews') }}
                <span class="text-sm font-normal text-gray-500">{{ __('dashboard.from_all_companies') }}</span>
            </h2>
        </div>
        <div class="p-6">
            @php
                $recentReviews = \App\Models\Review::with('company')
                    ->latest()
                    ->take(10)
                    ->get();
            @endphp
            
            @if($recentReviews->isEmpty())
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-comment-slash text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.no_reviews_yet') }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        {{ __('dashboard.no_reviews_all') }}
                    </p>
                </div>
            @else
                <div class="space-y-4" id="reviewsList">
                    @foreach($recentReviews as $review)
                    <div class="review-item p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg" data-rating="{{ $review->rating }}" data-is-positive="{{ $review->is_positive ? '1' : '0' }}">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-{{ $i <= $review->rating ? 'yellow' : 'gray' }}-400"></i>
                                    @endfor
                                    <span class="ml-2 text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $review->rating }}/5</span>
                                </div>
                                @if(isset($review->company))
                                    <span class="px-2 py-1 text-xs bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 rounded-full">
                                        {{ $review->company->name }}
                                    </span>
                                @endif
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-800 dark:text-gray-200">{{ $review->comment ?? __('dashboard.no_comment') }}</p>
                        @if($review->customer_phone)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                <i class="fas fa-phone mr-1"></i> {{ $review->customer_phone }}
                            </p>
                        @endif
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Stat card clickable styles */
    [id^="adminStatCard"] {
        transition: all 0.3s ease;
        user-select: none;
        position: relative;
    }
    
    [id^="adminStatCard"]:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
    }
    
    [id^="adminStatCard"]:active {
        transform: translateY(-2px) scale(0.98);
    }
    
    [id^="adminStatCard"].active {
        border-color: #667eea !important;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2) !important;
    }
    
    [id^="adminStatCard"] > * {
        position: relative;
        z-index: 2;
    }
    
    .review-item.hidden {
        display: none;
    }
</style>
@endsection

@section('scripts')
<script>
    let currentReviewFilter = 'all';
    
    function filterAdminReviews(filterType) {
        // Remove active state from all cards
        document.querySelectorAll('[id^="adminStatCard"]').forEach(card => {
            card.classList.remove('active');
        });
        
        // Get all review items
        const reviewItems = document.querySelectorAll('.review-item');
        
        if (filterType === 'all') {
            // Show all reviews
            reviewItems.forEach(item => {
                item.classList.remove('hidden');
            });
            // Highlight total card
            const totalCard = document.getElementById('adminStatCardTotal');
            if (totalCard) totalCard.classList.add('active');
            currentReviewFilter = 'all';
        } else if (filterType === 'positive') {
            // Show only positive reviews (rating >= 4)
            reviewItems.forEach(item => {
                const isPositive = item.getAttribute('data-is-positive') === '1';
                if (isPositive) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
            // Highlight positive card
            const positiveCard = document.getElementById('adminStatCardPositive');
            if (positiveCard) positiveCard.classList.add('active');
            currentReviewFilter = 'positive';
        } else if (filterType === 'negative') {
            // Show only negative reviews (rating < 4)
            reviewItems.forEach(item => {
                const isPositive = item.getAttribute('data-is-positive') === '1';
                if (!isPositive) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
            // Highlight negative card
            const negativeCard = document.getElementById('adminStatCardNegative');
            if (negativeCard) negativeCard.classList.add('active');
            currentReviewFilter = 'negative';
        }
        
        // Scroll to reviews section
        setTimeout(() => {
            const reviewsSection = document.getElementById('recentReviewsSection');
            if (reviewsSection) {
                reviewsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 100);
    }
    
    function scrollToRecentReviews() {
        const reviewsSection = document.getElementById('recentReviewsSection');
        if (reviewsSection) {
            reviewsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
</script>
@endsection
