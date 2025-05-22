<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Preload critical resources -->
    <link rel="preload" href="{{ asset('assets/vendor/tailwindcss/tailwindcss.js') }}" as="script">
    <link rel="preload" href="{{ asset('assets/vendor/font-awesome/css/all.min.css') }}" as="style">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">

    <!-- Inline critical CSS - Add more critical styles here -->
    <style>
        /* Hide everything until JS loads */
        .js-preload * {
            visibility: hidden;
        }

        /* Basic layout structure to prevent layout shift */
        #app {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Loading indicator styles */
        #initial-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .circular-loader {
            width: 50px;
            height: 50px;
            animation: rotate 2s linear infinite;
        }

        .circular-loader-path {
            stroke-dasharray: 150, 200;
            stroke-dashoffset: -10;
            animation: dash 1.5s ease-in-out infinite;
            stroke-linecap: round;
            stroke: #3b82f6;
        }

        @keyframes rotate {
            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes dash {
            0% {
                stroke-dasharray: 1, 200;
                stroke-dashoffset: 0;
            }

            50% {
                stroke-dasharray: 89, 200;
                stroke-dashoffset: -35;
            }

            100% {
                stroke-dasharray: 89, 200;
                stroke-dashoffset: -124;
            }
        }

        /* Add other critical styles from your original CSS */
        [x-cloak] {
            display: none !important;
        }

        .no-js .js-only {
            display: none;
        }

        .js .no-js-only {
            display: none;
        }
    </style>

    <!-- Load CSS -->
    <link href="{{ asset('assets/vendor/font-awesome/css/all.min.css') }}" rel="stylesheet" media="print"
        onload="this.media='all'">
    <noscript>
        <link href="{{ asset('assets/vendor/font-awesome/css/all.min.css') }}" rel="stylesheet">
    </noscript>

    @stack('styles')
</head>

<body
    class="h-full bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-200 js-preload">
    <!-- Initial loading screen -->
    <div id="initial-loader">
        <div class="circular-loader">
            <svg viewBox="25 25 50 50">
                <circle class="circular-loader-path" cx="50" cy="50" r="20" fill="none" stroke-width="4"
                    stroke-miterlimit="10" />
            </svg>
        </div>
    </div>

    <!-- No JS fallback -->
    <noscript>
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-red-100 p-4">
            <div class="text-center">
                <h2 class="text-2xl font-bold text-red-800 mb-2">JavaScript Required</h2>
                <p class="text-red-700">This application requires JavaScript to function properly.</p>
            </div>
        </div>
    </noscript>

    <!-- Progress Loader -->
    <div id="progress-loader" class="fixed top-0 left-0 w-full h-1 z-[9998] bg-transparent">
        <div id="progress-bar"
            class="h-full w-0 bg-gradient-to-r from-blue-500 to-purple-500 transition-all duration-300"></div>
    </div>

    <!-- App Container -->
    <div id="app" class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="relative flex flex-1 flex-col overflow-hidden">
            <!-- Header -->
            @include('layouts.header')

            <!-- Main Content Area -->
            <main class="flex-1 overflow-auto p-1 md:p-2 focus:outline-none">
                <div class="mx-auto max-w-[96rem]">
                    <!-- Compact Page Header -->
                    <header class="mb-1">
                        @hasSection('breadcrumbs')
                            <nav class="mt-1 text-sm">
                                @yield('breadcrumbs')
                            </nav>
                        @endif
                    </header>

                    <!-- Minimal Content Container -->
                    <div class="bg-white/90 dark:bg-gray-800/90 rounded p-1 shadow">
                        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-200 pl-2">
                            @yield('title', 'Untitled')
                        </h1>
                        @yield('content')
                    </div>
                </div>
            </main>

        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Immediately show we support JS
        document.documentElement.classList.add('js');
        document.documentElement.classList.remove('no-js');

        // Initialize application when DOM is ready
        document.addEventListener('DOMContentLoaded', function () {
            // Remove preload class to show content
            document.body.classList.remove('js-preload');

            // Hide initial loader
            document.getElementById('initial-loader').style.opacity = '0';
            setTimeout(() => {
                document.getElementById('initial-loader').style.display = 'none';
            }, 300);

            // Progress loader simulation
            const progressLoader = {
                init() {
                    this.progressBar = document.getElementById('progress-bar');
                    this.simulateProgress();
                },
                simulateProgress() {
                    let width = 0;
                    const interval = setInterval(() => {
                        if (width >= 90) {
                            clearInterval(interval);
                            return;
                        }
                        width += 10;
                        this.progressBar.style.width = width + '%';
                    }, 300);

                    window.addEventListener('load', () => {
                        this.progressBar.style.width = '100%';
                        setTimeout(() => {
                            document.getElementById('progress-loader').style.opacity = '0';
                            setTimeout(() => {
                                document.getElementById('progress-loader').style
                                    .display = 'none';
                            }, 300);
                        }, 300);
                    });
                }
            };

            // Initialize components
            progressLoader.init();
        });

        // Fallback in case DOMContentLoaded takes too long
        setTimeout(function () {
            if (document.body.classList.contains('js-preload')) {
                document.body.classList.remove('js-preload');
                document.getElementById('initial-loader').style.display = 'none';
            }
        }, 3000);
    </script>

    <!-- Tailwind CSS -->
    <script src="{{ asset('assets/vendor/tailwindcss/tailwindcss.js') }}" defer></script>

    @stack('scripts')
</body>

</html>