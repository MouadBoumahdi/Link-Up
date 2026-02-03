<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'LinkUp') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Instrument Sans', sans-serif;
                background-color: #f9fafb;
                color: #111827;
                min-height: 100vh;
                line-height: 1.5;
            }

            @media (prefers-color-scheme: dark) {
                body {
                    background-color: #111827;
                    color: #f9fafb;
                }
            }

            .container {
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
                padding: 1rem 1rem;
            }

            /* Navbar */
            header {
                padding: 1.5rem 0;
            }

            nav {
                display: flex;
                justify-content: flex-end;
                align-items: center;
                gap: 1rem;
            }

            .nav-link {
                display: inline-block;
                padding: 0.5rem 1.25rem;
                text-decoration: none;
                border: 1px solid #d1d5db;
                border-radius: 0.25rem;
                font-size: 0.875rem;
                color: inherit;
                transition: all 0.2s ease;
            }

            .nav-link:hover {
                border-color: #9ca3af;
            }

            .nav-link.transparent {
                border-color: transparent;
            }

            .nav-link.primary {
                background-color: #3b82f6;
                color: white;
                border-color: #3b82f6;
            }

            .nav-link.primary:hover {
                background-color: #2563eb;
            }

            @media (prefers-color-scheme: dark) {
                .nav-link {
                    border-color: #4b5563;
                }
                
                .nav-link:hover {
                    border-color: #6b7280;
                }
                
                .nav-link.transparent:hover {
                    background-color: #374151;
                }
            }

            /* Main Content */
            main {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                min-height: 80vh;
                padding: 2rem 1rem;
                text-align: center;
            }

            .welcome-container {
                max-width: 800px;
                margin: 0 auto;
            }

            h1 {
                font-size: 3rem;
                font-weight: 700;
                margin-bottom: 1.5rem;
                line-height: 1.2;
            }

            .highlight {
                color: #3b82f6;
            }

            @media (prefers-color-scheme: dark) {
                .highlight {
                    color: #60a5fa;
                }
            }

            .subtitle {
                font-size: 1.25rem;
                color: #6b7280;
                margin-bottom: 2rem;
                max-width: 600px;
                margin-left: auto;
                margin-right: auto;
            }

            @media (prefers-color-scheme: dark) {
                .subtitle {
                    color: #d1d5db;
                }
            }

            .button-group {
                display: flex;
                gap: 1rem;
                justify-content: center;
                flex-wrap: wrap;
                margin-bottom: 3rem;
            }

            .btn {
                padding: 0.75rem 2rem;
                border-radius: 0.5rem;
                font-weight: 500;
                text-decoration: none;
                transition: all 0.2s ease;
                font-size: 1rem;
                border: none;
                cursor: pointer;
                display: inline-block;
            }

            .btn-primary {
                background-color: #3b82f6;
                color: white;
            }

            .btn-primary:hover {
                background-color: #2563eb;
                transform: translateY(-2px);
            }

            .btn-secondary {
                background-color: transparent;
                color: inherit;
                border: 1px solid #d1d5db;
            }

            .btn-secondary:hover {
                background-color: #f3f4f6;
                transform: translateY(-2px);
            }

            @media (prefers-color-scheme: dark) {
                .btn-secondary {
                    border-color: #4b5563;
                }
                
                .btn-secondary:hover {
                    background-color: #374151;
                }
            }

            /* Features */
            .features {
                margin-top: 4rem;
                padding-top: 3rem;
                border-top: 1px solid #e5e7eb;
                width: 100%;
            }

            @media (prefers-color-scheme: dark) {
                .features {
                    border-top-color: #374151;
                }
            }

            .features h2 {
                font-size: 2rem;
                font-weight: 600;
                margin-bottom: 2rem;
            }

            .feature-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
                max-width: 900px;
                margin: 0 auto;
            }

            .feature-card {
                background-color: white;
                padding: 1.5rem;
                border-radius: 0.5rem;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                text-align: left;
            }

            @media (prefers-color-scheme: dark) {
                .feature-card {
                    background-color: #1f2937;
                    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
                }
            }

            .feature-card h3 {
                font-size: 1.25rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
                color: #111827;
            }

            @media (prefers-color-scheme: dark) {
                .feature-card h3 {
                    color: #f9fafb;
                }
            }

            .feature-card p {
                color: #6b7280;
                font-size: 0.95rem;
            }

            @media (prefers-color-scheme: dark) {
                .feature-card p {
                    color: #d1d5db;
                }
            }

            /* Footer */
            footer {
                margin-top: 4rem;
                padding: 2rem 0;
                border-top: 1px solid #e5e7eb;
                text-align: center;
                color: #6b7280;
                font-size: 0.875rem;
            }

            @media (prefers-color-scheme: dark) {
                footer {
                    border-top-color: #374151;
                    color: #9ca3af;
                }
            }

            /* Responsive */
            @media (max-width: 768px) {
                h1 {
                    font-size: 2.5rem;
                }
                
                .subtitle {
                    font-size: 1.125rem;
                }
                
                .button-group {
                    flex-direction: column;
                    align-items: center;
                }
                
                .btn {
                    width: 100%;
                    max-width: 300px;
                    text-align: center;
                }
                
                .feature-grid {
                    grid-template-columns: 1fr;
                }
                
                nav {
                    justify-content: center;
                }
            }

            @media (max-width: 480px) {
                h1 {
                    font-size: 2rem;
                }
                
                .subtitle {
                    font-size: 1rem;
                }
                
                .features h2 {
                    font-size: 1.75rem;
                }
            }
        </style>
    </head>
    <body>
        <!-- Navbar (kept as is) -->
        <header class="container">
            @if (Route::has('login'))
                <nav>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="nav-link">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="nav-link transparent">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="nav-link">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main>
            <div class="welcome-container">
                <h1>
                    Welcome to <span class="highlight">{{ config('app.name', 'LinkUp') }}</span>
                </h1>
                
                <p class="subtitle">
                    Thank you for visiting our application. We're excited to have you here and look forward to helping you meeting new friends.
                </p>

                <div class="button-group">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                            Go to Dashboard
                        </a>
                    @else
                        
                        <a href="{{ route('register') }}" class="btn btn-secondary">
                            Create Account
                        </a>
                    @endauth
                </div>
            </div>
        </main>
    </body>
</html>