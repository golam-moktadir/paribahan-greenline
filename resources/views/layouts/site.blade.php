<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TransSystem')</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .loader {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        .sidebar {
            transition: transform 0.3s ease;
        }

        .sidebar-hidden {
            transform: translateX(-100%);
        }

        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s, transform 0.5s;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }

        .badge-success {
            background: #28a745;
            color: white;
        }

        .badge-danger {
            background: #dc3545;
            color: white;
        }

        .badge-warning {
            background: #ffc107;
            color: #212529;
        }
    </style>
    @stack('styles')
</head>

<body class="h-full bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <!-- Loader -->
    <div id="loader"
        class="fixed inset-0 bg-gray-100 dark:bg-gray-900 flex items-center justify-center z-50 transition-opacity duration-300">
        <i class="fas fa-spinner text-4xl text-blue-600 loader"></i>
    </div>

    <!-- App Container -->
    <div id="app" class="flex h-screen overflow-hidden">

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 shadow sticky top-0 z-30">
                <nav class="container mx-auto px-4 py-4 flex items-center justify-between">
                    <button id="sidebar-open" class="md:hidden text-gray-600 dark:text-gray-300">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="{{ route('drivers.index') }}"
                            class="text-gray-600 dark:text-gray-300 hover:text-blue-600 transition">Drivers</a>
                        <a href="" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 transition">Others</a>
                        <a href="{{ route('drivers.create') }}"
                            class="text-gray-600 dark:text-gray-300 hover:text-blue-600 transition">Add Driver</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        @auth
                            <form method="POST" action="">
                                @csrf
                                <button type="submit"
                                    class="text-gray-600 dark:text-gray-300 hover:text-red-600 transition">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        @else
                            <a href="" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 transition">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        @endauth
                    </div>
                </nav>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-auto p-4 md:p-6">
                <div class="container mx-auto max-w-7xl">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 md:p-6">
                        @yield('content')
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-gray-900 text-white py-6">
                <div class="container mx-auto px-4 text-center">
                    <p class="text-sm mb-2">© {{ date('Y') }} Transport. All rights reserved.</p>
                    <div class="flex justify-center space-x-4">
                        <a href="" class="text-gray-400 hover:text-white transition">Home</a>
                        <a href="" class="text-gray-400 hover:text-white transition">Drivers</a>
                        <a href="" class="text-gray-400 hover:text-white transition">Others</a>
                        <a href="{{ route('drivers.create') }}" class="text-gray-400 hover:text-white transition">Add
                            Driver</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Hide loader
            const loader = document.getElementById('loader');
            loader.style.opacity = '0';
            setTimeout(() => loader.style.display = 'none', 300);

            // Sidebar toggle
            const sidebar = document.querySelector('.sidebar');
            const sidebarOpen = document.getElementById('sidebar-open');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            sidebarOpen.addEventListener('click', () => sidebar.classList.remove('sidebar-hidden'));
            sidebarToggle.addEventListener('click', () => sidebar.classList.add('sidebar-hidden'));
        });
    </script>
    @stack('scripts')
</body>

</html>