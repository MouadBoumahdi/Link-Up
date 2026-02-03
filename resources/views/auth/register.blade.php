<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - {{ config('app.name', 'Laravel') }}</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            width: 100%;
            max-width: 450px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .register-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .register-header h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .register-header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .register-body {
            padding: 40px 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .form-label span {
            color: #e53e3e;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #4facfe;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        }

        .form-input::placeholder {
            color: #a0aec0;
        }

        .error-message {
            color: #e53e3e;
            font-size: 14px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .error-message::before {
            content: "⚠";
        }

        .password-hint {
            font-size: 12px;
            color: #718096;
            margin-top: 4px;
            display: block;
        }

        .password-strength {
            margin-top: 8px;
            height: 4px;
            background: #e2e8f0;
            border-radius: 2px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0%;
            background: #48bb78;
            transition: width 0.3s ease;
        }

        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 25px 0;
            padding: 12px;
            background: #f7fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .terms-checkbox input[type="checkbox"] {
            margin-top: 3px;
            min-width: 18px;
            height: 18px;
            border: 2px solid #cbd5e0;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .terms-checkbox input[type="checkbox"]:checked {
            background-color: #4facfe;
            border-color: #4facfe;
        }

        .terms-checkbox label {
            font-size: 14px;
            color: #4a5568;
            line-height: 1.5;
            cursor: pointer;
        }

        .terms-checkbox label a {
            color: #4facfe;
            text-decoration: none;
        }

        .terms-checkbox label a:hover {
            text-decoration: underline;
        }

        .register-button {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 24px;
        }

        .register-button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(79, 172, 254, 0.2);
        }

        .register-button:active:not(:disabled) {
            transform: translateY(0);
        }

        .register-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .login-link {
            text-align: center;
            font-size: 14px;
            color: #718096;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .login-link a {
            color: #4facfe;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .register-container {
                max-width: 100%;
            }
            
            .register-header,
            .register-body {
                padding: 30px 20px;
            }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            body {
                background: linear-gradient(135deg, #2c5282 0%, #3182ce 100%);
            }

            .register-container {
                background: #1a202c;
                color: #e2e8f0;
            }

            .form-label {
                color: #e2e8f0;
            }

            .form-input {
                background: #2d3748;
                border-color: #4a5568;
                color: #e2e8f0;
            }

            .form-input:focus {
                border-color: #4facfe;
            }

            .password-hint {
                color: #a0aec0;
            }

            .terms-checkbox {
                background: #2d3748;
                border-color: #4a5568;
            }

            .terms-checkbox label {
                color: #cbd5e0;
            }

            .login-link {
                color: #a0aec0;
                border-top-color: #4a5568;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const passwordStrengthBar = document.getElementById('password-strength-bar');
            const registerButton = document.querySelector('.register-button');
            const termsCheckbox = document.getElementById('terms');
            
            // Password strength indicator
            if (passwordInput && passwordStrengthBar) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    let strength = 0;
                    
                    if (password.length >= 8) strength += 25;
                    if (/[A-Z]/.test(password)) strength += 25;
                    if (/[0-9]/.test(password)) strength += 25;
                    if (/[^A-Za-z0-9]/.test(password)) strength += 25;
                    
                    passwordStrengthBar.style.width = strength + '%';
                    
                    // Update color based on strength
                    if (strength < 50) {
                        passwordStrengthBar.style.backgroundColor = '#e53e3e';
                    } else if (strength < 75) {
                        passwordStrengthBar.style.backgroundColor = '#d69e2e';
                    } else {
                        passwordStrengthBar.style.backgroundColor = '#48bb78';
                    }
                });
            }
            
            // Password confirmation check
            if (passwordInput && confirmPasswordInput) {
                function checkPasswordMatch() {
                    const password = passwordInput.value;
                    const confirmPassword = confirmPasswordInput.value;
                    
                    if (confirmPassword === '') return;
                    
                    if (password !== confirmPassword) {
                        confirmPasswordInput.style.borderColor = '#e53e3e';
                        confirmPasswordInput.style.boxShadow = '0 0 0 3px rgba(229, 62, 62, 0.1)';
                    } else {
                        confirmPasswordInput.style.borderColor = '#48bb78';
                        confirmPasswordInput.style.boxShadow = '0 0 0 3px rgba(72, 187, 120, 0.1)';
                    }
                }
                
                passwordInput.addEventListener('input', checkPasswordMatch);
                confirmPasswordInput.addEventListener('input', checkPasswordMatch);
            }
            
            // Terms checkbox validation
            if (termsCheckbox && registerButton) {
                termsCheckbox.addEventListener('change', function() {
                    registerButton.disabled = !this.checked;
                });
                
                // Initially disable button
                registerButton.disabled = !termsCheckbox.checked;
            }
        });
    </script>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Create Account</h1>
            <p>Join our community today</p>
        </div>

        <div class="register-body">
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                <!-- CSRF token removed for learning purposes -->
                
                <!-- Name -->
                <div class="form-group">
                    <label for="name" class="form-label">Full Name <span>*</span></label>
                    <input 
                        id="name" 
                        type="text" 
                        name="name" 
                        value="{{ old('name') }}" 
                        class="form-input" 
                        placeholder="Enter your full name"
                        required 
                        autofocus 
                        autocomplete="name"
                    >
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address <span>*</span></label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        class="form-input" 
                        placeholder="Enter your email address"
                        required 
                        autocomplete="username"
                    >
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password <span>*</span></label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Create a secure password"
                        required 
                        autocomplete="new-password"
                    >
                    <span class="password-hint">Use at least 8 characters with uppercase, lowercase, and numbers</span>
                    <div class="password-strength">
                        <div id="password-strength-bar" class="password-strength-bar"></div>
                    </div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password <span>*</span></label>
                    <input 
                        id="password_confirmation" 
                        type="password" 
                        name="password_confirmation" 
                        class="form-input" 
                        placeholder="Re-enter your password"
                        required 
                        autocomplete="new-password"
                    >
                    @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="terms-checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
                        <span style="color: #e53e3e">*</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="register-button" id="registerButton">
                    Create Account
                </button>
            </form>

            <!-- Login Link -->
            <div class="login-link">
                Already have an account? 
                <a href="{{ route('login') }}">Sign in here</a>
            </div>
        </div>
    </div>
</body>
</html>