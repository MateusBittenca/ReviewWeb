<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('auth.title') }} - {{ __('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/lopgosDASHBOARD.png') }}?v=2">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/lopgosDASHBOARD.png') }}?v=2">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        body {
            background-color: #f9fafb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        /* Login Container */
        .login-container {
            background: white;
            border-radius: 0.75rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            position: relative;
        }
        
        /* Logo Section */
        .logo-container {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .logo-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            margin-bottom: 1.5rem;
        }
        
        .logo-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        
        .logo-container h1 {
            font-size: 1.875rem;
            font-weight: 800;
            color: #111827;
            margin-bottom: 0.5rem;
        }
        
        .logo-container p {
            color: #6b7280;
            font-size: 0.9375rem;
        }
        
        /* Input Groups */
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-field {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            font-size: 0.9375rem;
            transition: all 0.3s ease;
            background: white;
            color: #111827;
        }
        
        .input-field:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
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
            color: #8b5cf6;
        }
        
        /* Button */
        .btn-login {
            width: 100%;
            padding: 0.875rem 1.5rem;
            background: #8b5cf6;
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-size: 0.9375rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }
        
        .btn-login:hover {
            background: #7c3aed;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 92, 246, 0.25);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }
        
        /* Back Link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
        }
        
        .back-link:hover {
            color: #8b5cf6;
        }
        
        /* Language Selector */
        .language-selector {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 50;
        }
        
        .language-selector select {
            appearance: none;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.5rem 2rem 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .language-selector select:hover {
            border-color: #8b5cf6;
            background: #f9fafb;
        }
        
        .language-selector select:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }
        
        .language-selector::after {
            content: '\f078';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6b7280;
            font-size: 0.75rem;
        }
        
        /* Messages */
        .success-message {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }
        
        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }
        
        /* Additional Info */
        .additional-info {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.8125rem;
            color: #6b7280;
        }
        
        .additional-info p {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .additional-info i {
            color: #8b5cf6;
        }
        
        /* Animations */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .login-container {
                padding: 2rem 1.5rem;
            }
            
            .language-selector {
                top: 1rem;
                right: 1rem;
            }
            
            .logo-container h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Language Selector -->
    <div class="language-selector">
        <select id="languageSelector">
            <option value="pt_BR" {{ app()->getLocale() === 'pt_BR' ? 'selected' : '' }}>🇧🇷 PT</option>
            <option value="en_US" {{ app()->getLocale() === 'en_US' ? 'selected' : '' }}>🇬🇧 EN</option>
        </select>
    </div>
    
    <!-- Login Container -->
    <div class="login-container fade-in">
        <!-- Logo and Title -->
        <div class="logo-container">
            <div class="logo-wrapper">
                <img src="{{ asset('assets/images/lopgosDASHBOARD.png') }}" alt="{{ __('app.name') }}">
            </div>
            <h1>{{ __('auth.welcome_back') }}</h1>
            <p>{{ __('auth.login_subtitle') }}</p>
        </div>
        
        <!-- Messages -->
        @if(session('success'))
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        
        @if(session('error'))
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        
        @if($errors->any())
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif
        
        <!-- Login Form -->
        <form method="POST" action="/login">
            @csrf
            
            <!-- Email Field -->
            <div class="input-group">
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required
                    autocomplete="email"
                    class="input-field"
                    placeholder="{{ __('auth.email_placeholder') }}"
                >
                <i class="fas fa-envelope input-icon"></i>
            </div>
            
            <!-- Password Field -->
            <div class="input-group">
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    required
                    autocomplete="current-password"
                    class="input-field"
                    placeholder="{{ __('auth.password_placeholder') }}"
                >
                <i class="fas fa-lock input-icon"></i>
            </div>
            
            <!-- Login Button -->
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                <span>{{ __('auth.login_button') }}</span>
            </button>
        </form>
        
        <!-- Back Link -->
        <div style="text-align: center;">
            <a href="/" class="back-link">
                <i class="fas fa-arrow-left"></i>
                <span>{{ __('auth.back_to_home') }}</span>
            </a>
        </div>
        
        <!-- Additional Info -->
        <div class="additional-info">
            <p>
                <i class="fas fa-shield-alt"></i>
                <span>{{ __('auth.security_message') }}</span>
            </p>
            <p>{{ __('auth.platform_version') }}</p>
        </div>
    </div>
    
    <script>
        // Language Selector
        document.getElementById('languageSelector').addEventListener('change', function() {
            const locale = this.value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            fetch('/change-locale', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ locale: locale })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
        
        // Add loading state to button
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = document.querySelector('.btn-login');
            const originalHTML = button.innerHTML;
            
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>{{ __('auth.logging_in') }}</span>';
            button.disabled = true;
            
            // Re-enable after 5 seconds (in case of error)
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.disabled = false;
            }, 5000);
        });
        
        // Auto-focus first input
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            if (emailInput && !emailInput.value) {
                emailInput.focus();
            }
        });
    </script>
</body>
</html>
