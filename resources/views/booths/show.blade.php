@extends('layouts.app')

@section('title', 'View Booth Information')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/components/show-page.css') }}" as="style">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Booth Details</h1>
                <div class="flex gap-3">
                    <a href="{{ route('booths.edit', $booth) }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    <a href="{{ route('booths.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </a>
                </div>
            </div>

            <!-- Booth Information -->
            <div class="grid gap-4">
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">Booth Name</span>
                    <span class="w-2/3 text-sm text-gray-900">{{ $booth->booth_name ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">Booth Code</span>
                    <span class="w-2/3 text-sm text-gray-900">{{ $booth->booth_code ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">City</span>
                    <span class="w-2/3 text-sm text-gray-900">{{ $booth->station->city->city_name ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">Station</span>
                    <span class="w-2/3 text-sm text-gray-900">{{ $booth->station->station_name ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">Man in Charge</span>
                    <span class="w-2/3 text-sm text-gray-900">{{ $booth->employee->employee_name ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">Booth Address</span>
                    <span class="w-2/3 text-sm text-gray-900">{{ $booth->booth_address ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">Booth Phone</span>
                    <span class="w-2/3 text-sm text-gray-900">{{ $booth->booth_phone ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">VAT Registration No</span>
                    <span class="w-2/3 text-sm text-gray-900">{{ $booth->vat_no ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">Booth Currency</span>
                    <span class="w-2/3 text-sm text-gray-900">{{ $booth->currency ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">Master Booth</span>
                    <span class="w-2/3 text-sm text-gray-900">
                        @switch($booth->master_booth)
                            @case(0) Sub Booth @break
                            @case(1) Master Booth @break
                            @case(3) Sub Booth With Real IP @break
                            @default N/A
                        @endswitch
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">Parent Booth</span>
                    <span class="w-2/3 text-sm text-gray-900">
                        @if($booth->parent_booth && isset($parentBooths[$booth->parent_booth]))
                            {{ $parentBooths[$booth->parent_booth] ?? 'N/A' }}
                        @else
                            N/A
                        @endif
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">Booth IP</span>
                    <span class="w-2/3 text-sm text-gray-900">{{ $booth->booth_ip ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">Booth LAN IP</span>
                    <span class="w-2/3 text-sm text-gray-900">{{ $booth->booth_lan_ip ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">Server Connection Status</span>
                    <span class="w-2/3 text-sm text-gray-900">
                        {{ $booth->server_connection_status == 0 ? 'Connected through Internet' : 'Connected through LAN' }}
                    </span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">Online Booking</span>
                    <span class="w-2/3 text-sm text-gray-900">{{ $booth->booth_online_booking ? 'Enabled' : 'Disabled' }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-1/3 text-sm font-medium text-gray-700">Pocket Counter</span>
                    <span class="w-2/3 text-sm text-gray-900">{{ $booth->booth_pocket_counter ? 'Enabled' : 'Disabled' }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Add any necessary JavaScript here
    </script>
@endpush