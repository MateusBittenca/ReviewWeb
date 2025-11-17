@extends('layouts.admin')

@section('title', __('support.help_center_title'))
@section('page-title', __('support.help_center_title'))
@section('page-description', __('support.help_center_description'))

@section('content')
<div class="fade-in">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 rounded-xl border border-purple-200 dark:border-purple-800 p-4 sm:p-6 lg:p-8 mb-8">
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-purple-500 rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-life-ring text-white text-xl sm:text-2xl"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ __('support.help_center_title') }}</h1>
                <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300">{{ __('support.help_center_description') }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Guides Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
            <i class="fas fa-book text-purple-500 mr-2"></i>
            {{ __('support.quick_guides') }}
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Getting Started -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 card-hover">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-rocket text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('support.guide_getting_started') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ __('support.guide_getting_started_desc') }}</p>
                <a href="{{ route('support.faqs') }}#getting-started" class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium text-sm inline-flex items-center">
                    Saiba mais <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <!-- Sharing Link -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 card-hover">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-share-alt text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('support.guide_sharing_link') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ __('support.guide_sharing_link_desc') }}</p>
                <a href="{{ route('support.faqs') }}#sharing" class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium text-sm inline-flex items-center">
                    Saiba mais <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <!-- Viewing Reviews -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 card-hover">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-eye text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('support.guide_viewing_reviews') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ __('support.guide_viewing_reviews_desc') }}</p>
                <a href="{{ route('support.faqs') }}#managing-reviews" class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium text-sm inline-flex items-center">
                    Saiba mais <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <!-- Exporting -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 card-hover">
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-download text-yellow-600 dark:text-yellow-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('support.guide_exporting') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ __('support.guide_exporting_desc') }}</p>
                <a href="{{ route('support.faqs') }}#managing-reviews" class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium text-sm inline-flex items-center">
                    Saiba mais <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <!-- Multiple Companies -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 card-hover">
                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-building text-indigo-600 dark:text-indigo-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('support.guide_multiple_companies') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ __('support.guide_multiple_companies_desc') }}</p>
                <a href="{{ route('support.faqs') }}#multiple-companies" class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium text-sm inline-flex items-center">
                    Saiba mais <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Useful Resources Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
            <i class="fas fa-toolbox text-purple-500 mr-2"></i>
            {{ __('support.useful_resources') }}
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- FAQs -->
            <a href="{{ route('support.faqs') }}" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 card-hover block">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-question-circle text-purple-600 dark:text-purple-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('support.resource_faqs') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ __('support.resource_faqs_desc') }}</p>
            </a>

            <!-- Documentation -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 card-hover opacity-75">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-book text-blue-600 dark:text-blue-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('support.resource_documentation') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ __('support.resource_documentation_desc') }}</p>
                <span class="text-xs text-gray-500 dark:text-gray-400 mt-2 inline-block">Em breve</span>
            </div>

            <!-- Videos -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 card-hover opacity-75">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center mb-4">
                    <i class="fas fa-play-circle text-red-600 dark:text-red-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('support.resource_videos') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ __('support.resource_videos_desc') }}</p>
                <span class="text-xs text-gray-500 dark:text-gray-400 mt-2 inline-block">Em breve</span>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="bg-gradient-to-r from-purple-50 to-blue-50 dark:from-purple-900/20 dark:to-blue-900/20 rounded-xl border border-purple-200 dark:border-purple-800 p-8">
        <div class="text-center">
            <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-envelope text-white text-2xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ __('support.contact_title') }}</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-6">{{ __('support.contact_description') }}</p>
            <a href="mailto:{{ __('support.contact_email') }}" class="btn-primary inline-flex items-center gap-2 px-6 py-3 rounded-lg text-white font-medium">
                <i class="fas fa-envelope"></i>
                {{ __('support.contact_support') }}
            </a>
        </div>
    </div>
</div>
@endsection

