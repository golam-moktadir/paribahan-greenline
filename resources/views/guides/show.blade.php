@extends('layouts.app')

@section('title', 'View Guide - ' . ($guide->full_name ?? 'N/A'))

@push('styles')
@endpush

@section('content')
    <div class="container mx-auto">
        <div class="max-w-8xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 sm:p-8">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row items-center justify-between mb-8 gap-6">
                    <div class="flex items-center space-x-4">
                        @if ($guide->avatar_url)
                            <img src="{{ asset($guide->avatar_url) }}" alt="Guide Avatar"
                                class="w-32 h-32 rounded-full border-2 border-gray-200 dark:border-gray-600 object-cover"
                                loading="lazy">
                        @else
                            <div
                                class="w-32 h-32 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-user fa-2x"></i>
                            </div>
                        @endif
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <i class="fa fa-user-tie text-gray-600 dark:text-gray-300"></i>
                                {{ $guide->full_name ?? 'N/A' }}
                            </h1>
                            <span
                                class="inline-block px-2 py-1 text-xs font-medium rounded-full mt-1
                                {{ $guide->getStatusLabelAttribute() === 'Active'
                                    ? 'bg-green-500 text-white'
                                    : ($guide->getStatusLabelAttribute() === 'Inactive'
                                        ? 'bg-red-500 text-white'
                                        : 'bg-yellow-500 text-gray-900') }}">
                                {{ $guide->getStatusLabelAttribute() ?? 'Unknown' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('guides.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Back to List
                        </a>
                        <a href="{{ route('guides.edit', $guide->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-edit mr-2"></i> Edit Guide
                        </a>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Employment Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h2
                            class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">
                            Employment Information
                        </h2>
                        <dl class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex items-center">
                                <i class="fas fa-truck mr-2 text-gray-500"></i>
                                <dt class="font-medium">Transport:</dt>
                                <dd class="ml-2">{{ $guide->transport->transport_name ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-building mr-2 text-gray-500"></i>
                                <dt class="font-medium">Department:</dt>
                                <dd class="ml-2">{{ $guide->department->department_name ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                                <dt class="font-medium">Joining Date:</dt>
                                <dd class="ml-2">{{ $guide->joining_date?->format('d-m-Y') ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-user-shield mr-2 text-gray-500"></i>
                                <dt class="font-medium">Created By:</dt>
                                <dd class="ml-2">{{ $guide->creator->member_login ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Personal Information -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h2
                            class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">
                            Personal Information
                        </h2>
                        <dl class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2 text-gray-500"></i>
                                <dt class="font-medium">Full Name:</dt>
                                <dd class="ml-2">{{ $guide->full_name ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-user-tie mr-2 text-gray-500"></i>
                                <dt class="font-medium">Father’s Name:</dt>
                                <dd class="ml-2">{{ $guide->father_name ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-phone mr-2 text-gray-500"></i>
                                <dt class="font-medium">Phone:</dt>
                                <dd class="ml-2">{{ $guide->phone ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-id-card mr-2 text-gray-500"></i>
                                <dt class="font-medium">ID No.:</dt>
                                <dd class="ml-2">{{ $guide->id_no ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-birthday-cake mr-2 text-gray-500"></i>
                                <dt class="font-medium">Birth Date:</dt>
                                <dd class="ml-2">{{ $guide->birth_date?->format('d-m-Y') ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Identification & Work Info -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h2
                            class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">
                            Identification
                        </h2>
                        <dl class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex items-center">
                                <i class="fas fa-id-badge mr-2 text-gray-500"></i>
                                <dt class="font-medium">NID No.:</dt>
                                <dd class="ml-2">{{ $guide->nid_no ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-shield-alt mr-2 text-gray-500"></i>
                                <dt class="font-medium">Insurance No.:</dt>
                                <dd class="ml-2">{{ $guide->insurance_no ?? 'N/A' }}</dd>
                            </div>
                        </dl>
                        <h2
                            class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600 pb-2 mt-6 mb-4">
                            Work Information
                        </h2>
                        <dl class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex items-center">
                                <i class="fas fa-user-check mr-2 text-gray-500"></i>
                                <dt class="font-medium">Reference:</dt>
                                <dd class="ml-2">{{ $guide->reference ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-briefcase mr-2 text-gray-500"></i>
                                <dt class="font-medium">Experience:</dt>
                                <dd class="ml-2">{{ $guide->pre_experience ?? '0' }} years</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Addresses -->
                <div class="mt-8 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <h2
                        class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">
                        Addresses
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600 dark:text-gray-300">
                        <div class="flex items-center">
                            <i class="fas fa-home mr-2 text-gray-500"></i>
                            <strong class="font-medium">Present Address:</strong>
                            <span class="ml-2">{{ $guide->present_address ?? 'N/A' }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                            <strong class="font-medium">Permanent Address:</strong>
                            <span class="ml-2">{{ $guide->permanent_address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Attachments -->
                <div class="mt-8">
                    <h2
                        class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">
                        Attachments
                    </h2>
                    @if ($guide->nid_attachment || $driver->insurance_attachment)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                            @if ($guide->nid_attachment)
                                <div class="group">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">NID Attachment</p>
                                    <div
                                        class="w-full max-w-md h-auto aspect-video bg-gray-100 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600">
                                        <img src="{{ asset($guide->nid_attachment) }}" alt="NID Attachment"
                                            class="w-full h-full object-contain hover:shadow-md transition-shadow"
                                            loading="lazy">
                                    </div>
                                </div>
                            @endif
                            @if ($guide->insurance_attachment)
                                <div class="group">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Insurance</p>
                                    <div
                                        class="w-full max-w-md h-auto aspect-video bg-gray-100 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600">
                                        <img src="{{ asset($guide->insurance_attachment) }}" alt="Insurance Attachment"
                                            class="w-full h-full object-contain hover:shadow-md transition-shadow"
                                            loading="lazy">
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">No attachments available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
