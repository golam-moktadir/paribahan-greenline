@extends('layouts.app')

@section('title', 'View Offence #' . $offence->id)

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/components/show-page.css') }}" as="style">
@endpush

@section('content')
    <div class="container mx-auto p-2">
        <div class="card">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row items-center justify-between mb-4 gap-4">
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fas fa-balance-scale text-gray-500"></i>
                    Offence #{{ $offence->id }} - {{ $offence->driver->full_name ?? 'N/A' }}
                </h1>
                <div class="flex gap-3">
                    <a href="{{ route('offences.edit', $offence) }}" class="action-btn edit-btn">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    <a href="{{ route('offences.index') }}" class="action-btn back-btn">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid-container">
                <!-- Offence Information -->
                <div>
                    <h2 class="section-title">Offence Information</h2>
                    <div class="field-group">
                        <span class="field-label">Driver</span>
                        <div class="field-value">
                            <strong>Name:</strong> {{ $offence->driver->full_name ?? 'N/A' }}<br>
                            <strong>ID No:</strong> {{ $offence->driver->id_no ?? 'N/A' }}<br>
                            <strong>Phone:</strong> {{ $offence->driver->phone ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="field-group">
                        <span class="field-label">Offence Type</span>
                        <div class="field-value">
                            <span class="badge {{ $offence->offence_type ? 'badge-' . $offence->offence_type_class : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $offence->offence_type ?? 'N/A')) }}
                            </span>
                        </div>
                    </div>
                    <div class="field-group">
                        <span class="field-label">Occurrence Date</span>
                        <div class="field-value">
                            {{ $offence->occurrence_date?->format('F j, Y') ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="field-group">
                        <span class="field-label">Description</span>
                        <div class="field-value" style="min-height: 4rem;">
                            {{ $offence->description ?? 'N/A' }}
                        </div>
                    </div>
                </div>

                <!-- Complainant Information -->
                <div>
                    <h2 class="section-title">Complainant Information</h2>
                    <div class="field-group">
                        <span class="field-label">Name</span>
                        <div class="field-value">
                            {{ $offence->complainant_name ?? 'N/A' }}
                        </div>
                    </div>
                    <div class="field-group">
                        <span class="field-label">Phone Number</span>
                        <div class="field-value">
                            {{ $offence->complainant_phone ?? 'N/A' }}
                        </div>
                    </div>
                    <h2 class="section-title">Attachments</h2>

                    <div class="attachment-list">
                        @if ($offence->attachments->isNotEmpty())
                            @foreach ($offence->attachments as $index => $attachment)
                                <div class="attachment-item">
                                    @php
                                        $path = $attachment->path;
                                        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                                    @endphp

                                    <a href="{{ asset($path) }}" target="_blank" rel="noopener noreferrer"
                                        class="flex items-center space-x-2">
                                        @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset($path) }}" alt="Attachment {{ $index + 1 }}"
                                                class="w-32 h-32 object-cover mb-2">
                                        @else
                                            <i class="fas fa-file-pdf text-red-600 text-2xl"></i>
                                            <span class="text-blue-600 underline">Click to view</span>
                                        @endif
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-500">No attachments available.</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add lazy loading for attachment images
            const images = document.querySelectorAll('.attachment-item img');
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            observer.unobserve(img);
                        }
                    });
                });
                images.forEach(img => {
                    img.dataset.src = img.src;
                    img.src = '';
                    observer.observe(img);
                });
            }
        });
    </script>
@endpush
