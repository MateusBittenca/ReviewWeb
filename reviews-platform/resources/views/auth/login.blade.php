<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('auth.title') }} - {{ __('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/lopgosDASHBOARD.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/lopgosDASHBOARD.png') }}">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }
        
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        
        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }
        
        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        
        .shape:nth-child(4) {
            width: 100px;
            height: 100px;
            top: 30%;
            right: 30%;
            animation-delay: 1s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .login-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.1);
        }
        
        .input-group {
            position: relative;
            transition: transform 0.3s ease;
        }
        
        .input-field {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #ffffff;
            box-sizing: border-box;
        }
        
        .input-field:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            transition: color 0.3s ease;
            pointer-events: none;
            z-index: 1;
        }
        
        .input-group:focus-within .input-icon {
            color: #667eea;
        }
        
        .input-field:focus + .input-icon {
            color: #667eea;
        }
        
        .btn-login {
            width: 100%;
            padding: 1rem;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .btn-login:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
            z-index: 0;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login > * {
            position: relative;
            z-index: 1;
        }
        
        .logo-container {
            animation: logoFloat 3s ease-in-out infinite;
        }
        
        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .slide-in-left {
            animation: slideInLeft 0.8s ease-out;
        }
        
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .slide-in-right {
            animation: slideInRight 0.8s ease-out;
        }
        
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .back-link {
            color: #667eea;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .back-link:hover {
            color: #764ba2;
            transform: translateX(-5px);
        }
        
        .success-message {
            background: #10b981;
            color: white;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            animation: slideDown 0.5s ease-out;
        }
        
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .error-message {
            background: #ef4444;
            color: white;
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            animation: slideDown 0.5s ease-out;
        }
        
        .language-selector {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 50;
        }
        
        .language-selector-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 0.5rem;
        }
        
        .language-link {
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .language-link.active {
            background: #667eea;
            color: white;
        }
        
        .language-link:not(.active) {
            color: #4b5563;
        }
        
        .language-link:not(.active):hover {
            background: #f3f4f6;
        }
        
        @media (max-width: 768px) {
            .login-container {
                margin: 1rem;
                padding: 2rem 1.5rem;
            }
            
            .shape {
                display: none;
            }
            
            .language-selector {
                top: 0.5rem;
                right: 0.5rem;
            }
            
            .language-link {
                padding: 0.375rem 0.5rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Language Selector -->
    <div class="language-selector">
        <div class="language-selector-container">
            <div class="flex items-center space-x-1">
                <a href="?lang=pt_BR" class="language-link {{ app()->getLocale() === 'pt_BR' ? 'active' : '' }}">
                    🇧🇷 PT
                </a>
                <a href="?lang=en_US" class="language-link {{ app()->getLocale() === 'en_US' ? 'active' : '' }}">
                    🇬🇧 EN
                </a>
            </div>
        </div>
    </div>
    
    <!-- Floating Background Shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <!-- Login Container -->
    <div class="login-container rounded-2xl p-8 w-full max-w-md relative z-10 fade-in">
        <!-- Logo and Title -->
        <div class="text-center mb-8 logo-container">
            <div class="inline-flex items-center justify-center w-28 h-28 mb-4 pulse-animation">
                <img src="{{ asset('assets/images/lopgosDASHBOARD.png') }}" alt="{{ __('app.name') }}" class="w-28 h-28 object-contain" style="background: transparent;">
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ __('auth.welcome_back') }}</h1>
            <p class="text-gray-600">{{ __('auth.login_subtitle') }}</p>
        </div>
        
        <!-- Login Form -->
        <form method="POST" action="/login" class="space-y-6">
            @csrf
            
            <!-- Email Field -->
            <div class="input-group slide-in-left">
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required
                    autocomplete="off"
                    class="input-field"
                    placeholder="{{ __('auth.email_placeholder') }}"
                >
                <i class="fas fa-envelope input-icon"></i>
            </div>
            
            <!-- Password Field -->
            <div class="input-group slide-in-right">
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    autocomplete="off"
                    class="input-field"
                    placeholder="{{ __('auth.password_placeholder') }}"
                >
                <i class="fas fa-lock input-icon"></i>
            </div>
            
            <!-- Login Button -->
            <button type="submit" class="btn-login fade-in w-full">
                <i class="fas fa-arrow-right mr-2"></i>
                {{ __('auth.login_button') }}
            </button>
        </form>
        
        <!-- Back Link -->
        <div class="text-center mt-6 fade-in">
            <a href="/" class="back-link">
                <i class="fas fa-arrow-left"></i>
                {{ __('auth.back_to_home') }}
            </a>
        </div>
        
        <!-- Additional Info -->
        <div class="mt-8 text-center text-sm text-gray-500 fade-in">
            <p class="flex items-center justify-center gap-2">
                <i class="fas fa-lock text-orange-500"></i>
                {{ __('auth.security_message') }}
            </p>
            <p class="mt-1">{{ __('auth.platform_version') }}</p>
        </div>
    </div>
    
    <!-- JavaScript for Enhanced Interactions -->
    <script>
        // Translations for JavaScript
        const translations = {
            pt_BR: {
                logging_in: '{{ __('auth.logging_in') }}',
                login_success: '{{ __('auth.login_success') }}',
                login_error: '{{ __('auth.login_error') }}'
            },
            en_US: {
                logging_in: '{{ __('auth.logging_in') }}',
                login_success: '{{ __('auth.login_success') }}',
                login_error: '{{ __('auth.login_error') }}'
            }
        };
        
        const currentLang = '{{ app()->getLocale() }}';
        const t = translations[currentLang] || translations.pt_BR;
        
        // Add loading state to button
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = document.querySelector('.btn-login');
            const originalText = button.innerHTML;
            
            button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>' + t.logging_in;
            button.disabled = true;
            
            // Re-enable after 3 seconds (in case of error)
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 3000);
        });
        
        // Add focus animations
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
        
        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && e.target.classList.contains('input-field')) {
                const inputs = Array.from(document.querySelectorAll('.input-field'));
                const currentIndex = inputs.indexOf(e.target);
                
                if (currentIndex < inputs.length - 1) {
                    inputs[currentIndex + 1].focus();
                } else {
                    document.querySelector('.btn-login').click();
                }
            }
        });
        
        // Add success/error message handling
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success')) {
            const successDiv = document.createElement('div');
            successDiv.className = 'success-message';
            successDiv.innerHTML = '<i class="fas fa-check-circle mr-2"></i>' + t.login_success;
            document.querySelector('form').insertBefore(successDiv, document.querySelector('form').firstChild);
        }
        
        if (urlParams.get('error')) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i>' + t.login_error;
            document.querySelector('form').insertBefore(errorDiv, document.querySelector('form').firstChild);
        }
    </script>
</body>
</html>