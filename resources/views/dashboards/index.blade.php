@extends('layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
    <div class="mx-auto max-w-8xl p-2 sm:p-4">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Transports Card -->
            <div
                class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition-shadow hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center">
                    <div class="rounded-lg bg-blue-100 p-3 dark:bg-blue-900/20">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Transports</p>
                        <p class="text-xl font-semibold dark:text-white">
                            {{ $stats['transports'] ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Departments Card -->
            <div
                class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition-shadow hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center">
                    <div class="rounded-lg bg-cyan-100 p-3 dark:bg-cyan-900/20">
                        <svg class="h-6 w-6 text-cyan-600 dark:text-cyan-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Departments</p>
                        <p class="text-xl font-semibold dark:text-white">
                            {{ $stats['departments'] ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Work Group Card -->
            <div
                class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition-shadow hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="rounded-lg bg-indigo-100 p-3 dark:bg-indigo-900/20">
                            <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Work Groups</p>
                            <p class="text-xl font-semibold dark:text-white">
                                {{ $stats['work_groups'] ?? 0 }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employees Card -->
            <div
                class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition-shadow hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center">
                    <div class="rounded-lg bg-purple-100 p-3 dark:bg-purple-900/20">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Employees</p>
                        <div class="flex items-center">
                            <p class="text-xl font-semibold dark:text-white">
                                {{ $stats['employees']['count'] ?? 0 }}
                            </p>
                            @if (isset($stats['employees']['change']) && $stats['employees']['change'] > 0)
                                <span class="ml-2 text-xs text-green-500">+{{ $stats['employees']['change'] }} today</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Content Sections -->
        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Recent Activity Section -->
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">Recent Activity</h3>
                <div class="space-y-4">
                    @forelse(($stats['recent_activities'] ?? []) as $activity)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 pt-0.5">
                                <div
                                    class="h-3 w-3 rounded-full {{ $loop->index % 2 === 0 ? 'bg-blue-500' : 'bg-green-500' }}">
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $activity->description ?? 'No description available' }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ isset($activity->created_at) ? $activity->created_at->diffForHumans() : 'Just now' }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="flex items-center justify-center py-4 text-gray-500 dark:text-gray-400">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            No recent activities found
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions Section -->
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold text-gray-800 dark:text-white">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="#"
                        class="flex items-center justify-center rounded-lg bg-gray-100 px-4 py-3 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        New Transport
                    </a>
                    <a href="{{ route('employees.create') }}"
                        class="flex items-center justify-center rounded-lg bg-gray-100 px-4 py-3 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-200 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Add Employee
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
