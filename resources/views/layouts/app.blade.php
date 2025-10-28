<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Job Board') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-[#0a0a0a] border-b border-[#19140035] dark:border-[#3E3E3A] shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo and Brand -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <a href="{{ url('/') }}" class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] hover:text-gray-700 dark:hover:text-gray-300">
                                {{ config('app.name', 'Job Board') }}
                            </a>
                        </div>

                        <!-- Primary Navigation Menu -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <a href="{{ url('/') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:text-gray-700 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300">
                                Home
                            </a>
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:text-gray-700 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300">
                                    Dashboard
                                </a>
                                @can('viewApplications', auth()->user())
                                    <a href="{{ route('applications.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:text-gray-700 dark:hover:text-gray-300 border-b-2 border-transparent hover:border-gray-300">
                                        Applications
                                    </a>
                                @endcan
                            @endauth
                        </div>
                    </div>

                    <!-- Authentication Links -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @auth
                            <div class="flex items-center space-x-4">
                                <span class="text-sm text-[#1b1b18] dark:text-[#EDEDEC]">
                                    Welcome, {{ Auth::user()->name }}
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium ml-1 {{ Auth::user()->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst(Auth::user()->role) }}
                                    </span>
                                </span>

                                <a href="{{ route('dashboard') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal transition">
                                    Dashboard
                                </a>

                                @can('viewApplications', auth()->user())
                                    <a href="{{ route('applications.index') }}" class="inline-block px-5 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition">
                                        Applications
                                    </a>
                                @endcan

                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal transition">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal transition">
                                    Log in
                                </a>
                                
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal transition">
                                        Register
                                    </a>
                                @endif
                            </div>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="sm:hidden flex items-center">
                        <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path class="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path class="close-icon hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation Menu -->
            <div id="mobile-menu" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ url('/') }}" class="block px-3 py-2 text-base font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        Home
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-base font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            Dashboard
                        </a>
                        @can('viewApplications', auth()->user())
                            <a href="{{ route('applications.index') }}" class="block px-3 py-2 text-base font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                Applications
                            </a>
                        @endcan
                    @endauth
                </div>
                
                <div class="pt-4 pb-1 border-t border-[#19140035] dark:border-[#3E3E3A]">
                    @auth
                        <div class="px-4">
                            <div class="text-base font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ Auth::user()->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst(Auth::user()->role) }}
                                </span>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-base font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                Dashboard
                            </a>
                            @can('viewApplications', auth()->user())
                                <a href="{{ route('applications.index') }}" class="block px-4 py-2 text-base font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                    Applications
                                </a>
                            @endcan
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mt-3 space-y-1">
                            <a href="{{ route('login') }}" class="block px-4 py-2 text-base font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="block px-4 py-2 text-base font-medium text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                    Register
                                </a>
                            @endif
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="min-h-screen">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-[#0a0a0a] border-t border-[#19140035] dark:border-[#3E3E3A] mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">{{ config('app.name', 'Job Board') }}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            Find your dream job or post opportunities for talented candidates.
                        </p>
                    </div>
                    <div>
                        <h4 class="text-md font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-4">Quick Links</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ url('/') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition">Home</a></li>
                            <li><a href="{{ url('/jobs') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition">Browse Jobs</a></li>
                            @auth
                                <li><a href="{{ url('/jobs/create') }}" class="text-gray-600 dark:text-gray-400 hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition">Post a Job</a></li>
                            @endauth
                        </ul>
                    </div>
                    <div>
                        <h4 class="text-md font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-4">Contact</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">
                            Need help? Contact our support team.
                        </p>
                    </div>
                </div>
                <div class="border-t border-[#19140035] dark:border-[#3E3E3A] mt-8 pt-8 text-center">
                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                        © {{ date('Y') }} {{ config('app.name', 'Job Board') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>

        <!-- Flash Messages -->
        @if (session('success'))
            <div id="flash-success" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 transition-opacity">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (session('error'))
            <div id="flash-error" class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 transition-opacity">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if (session('warning'))
            <div id="flash-warning" class="fixed bottom-4 right-4 bg-yellow-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 transition-opacity">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('warning') }}
                </div>
            </div>
        @endif

        @livewireScripts

        <!-- CSRF Protection Script -->
        <script>
            // Setup global CSRF token
            window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            window.Laravel = { csrfToken: window.csrfToken };

            document.addEventListener('DOMContentLoaded', function() {
                // Update CSRF token after each page load
                const updateCsrfToken = () => {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    if (token) {
                        window.csrfToken = token;
                        window.Laravel.csrfToken = token;
                    }
                };

                // Update CSRF token
                updateCsrfToken();

                // For Livewire requests
                if (window.Livewire) {
                    // Before request
                    Livewire.hook('request', ({ options, payload, respond, succeed, fail }) => {
                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        if (token) {
                            options.headers = options.headers || {};
                            options.headers['X-CSRF-TOKEN'] = token;
                        }
                    });

                    // Handle CSRF errors
                    Livewire.hook('request', ({ fail }) => {
                        fail(({ status, content, xhr }) => {
                            if (status === 419) {
                                console.warn('CSRF token mismatch detected, reloading page...');
                                window.location.reload();
                            }
                        });
                    });

                    // Update token after successful requests
                    Livewire.hook('request', ({ succeed }) => {
                        succeed(({ status, json }) => {
                            updateCsrfToken();
                        });
                    });
                }

                // Handle form submissions
                document.querySelectorAll('form').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        const tokenInput = form.querySelector('input[name="_token"]');
                        if (tokenInput) {
                            const currentToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                            if (currentToken) {
                                tokenInput.value = currentToken;
                            }
                        }
                    });
                });

                // Handle AJAX requests
                const originalFetch = window.fetch;
                window.fetch = function() {
                    let [resource, config] = arguments;
                    
                    if (config && config.method && config.method.toUpperCase() !== 'GET') {
                        config.headers = config.headers || {};
                        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                        if (token) {
                            config.headers['X-CSRF-TOKEN'] = token;
                        }
                    }
                    
                    return originalFetch.apply(this, arguments);
                };
            });
        </script>

        <!-- Mobile Menu JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.getElementById('mobile-menu-button');
                const mobileMenu = document.getElementById('mobile-menu');
                const menuIcon = document.querySelector('.menu-icon');
                const closeIcon = document.querySelector('.close-icon');

                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                    menuIcon.classList.toggle('hidden');
                    closeIcon.classList.toggle('hidden');
                });

                // Auto-dismiss flash messages
                const flashMessages = document.querySelectorAll('[id^="flash-"]');
                flashMessages.forEach(function(message) {
                    setTimeout(function() {
                        message.style.opacity = '0';
                        setTimeout(function() {
                            message.remove();
                        }, 300);
                    }, 3000);
                });

                // Handle redirect to login events from Livewire
                window.addEventListener('livewire:init', () => {
                    Livewire.on('redirectToLogin', () => {
                        window.location.href = '{{ route("login") }}';
                    });
                });
            });
        </script>
    </body>
</html>