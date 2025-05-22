@extends('layouts.site')

@section('title', 'Transport - Home')

@push('styles')
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #3b82f6, #10b981);
            animation: gradientShift 15s ease infinite;
            background-size: 200% 200%;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .btn {
            transition: transform 0.2s, background-color 0.2s;
        }

        .btn:hover {
            transform: scale(1.05);
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
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-bg text-white py-16 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-4 fade-in">Welcome to Transport</h1>
            <p class="text-lg md:text-xl mb-8 fade-in" style="transition-delay: 0.2s;">Streamline driver management,
                transport tracking, and department operations.</p>
            <div class="flex justify-center space-x-4 fade-in" style="transition-delay: 0.4s;">
                <a href="{{ route('dashboard') }}"
                    class="btn inline-flex items-center px-6 py-3 bg-white text-blue-600 rounded-lg shadow hover:bg-gray-100">
                    <i class="fas fa-users mr-2"></i> Go to Dashboard
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div class="fade-in">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Driver::active()->count() }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">Active Drivers</p>
                    <span class="badge badge-success mt-2 inline-block">Operational</span>
                </div>
                <div class="fade-in" style="transition-delay: 0.2s;">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Driver::count() }}</h3>
                    <p class="text-gray-600 dark:text-gray-300">Total Drivers</p>
                </div>
                <div class="fade-in" style="transition-delay: 0.4s;">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">N/A</h3>
                    <p class="text-gray-600 dark:text-gray-300">Active Transports</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-100 dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12 fade-in">Our Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 fade-in">
                    <i class="fas fa-user-tie text-4xl text-blue-600 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Driver Management</h3>
                    <p class="text-gray-600 dark:text-gray-300">Manage driver profiles, statuses, and documents with ease.
                    </p>
                </div>
                <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 fade-in"
                    style="transition-delay: 0.2s;">
                    <i class="fas fa-truck text-4xl text-blue-600 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Transport Tracking</h3>
                    <p class="text-gray-600 dark:text-gray-300">Monitor transport assignments and statuses in real-time.</p>
                </div>
                <div class="card bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 fade-in"
                    style="transition-delay: 0.4s;">
                    <i class="fas fa-building text-4xl text-blue-600 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Department Oversight</h3>
                    <p class="text-gray-600 dark:text-gray-300">Organize and oversee department operations seamlessly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-white dark:bg-gray-800">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4 fade-in">Get Started Today</h2>
            <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 fade-in">Take control of your transportation operations
                with Transport.</p>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Scroll reveal animations
            const elements = document.querySelectorAll('.fade-in');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            elements.forEach(element => observer.observe(element));
        });
    </script>
@endpush