
@extends('layouts.app')

@section('title', 'Edit Station')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/flatpickr.min.css') }}">
@endpush

@section('content')
    <div class="form-container">
        <div class="card">
            @if ($errors->any())
                <div class="error-message">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route($resource.'.update',  $single->station_id) }}" enctype="multipart/form-data"
                class="max-w-lg w-full p-6 bg-white shadow-md rounded-lg space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 gap-4 text-left">
                    <input type="hidden" name="station_saved_by" value="1">
                    <div>
                        <label for="station_name" class="block text-sm font-medium text-gray-700 mb-1">Station Name <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="station_name" id="station_name" value="{{ $single->station_name }}" class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('station_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="city_id" class="block text-sm font-medium text-gray-700 mb-1">City <span
                                class="text-red-500">*</span></label>
                        <select name="city_id" id="city_id" class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <option value="">--Select City--</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->city_id }}" {{ $single->city_id == $city->city_id ? 'selected' : '' }}>
                                    {{ $city->city_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('city_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="station_location" class="block text-sm font-medium text-gray-700 mb-1">Station Address <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="station_location" id="station_location" value="{{ $single->station_location }}" class="w-full px-3 py-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        @error('station_location')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mt-6 text-right">
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">Update
                    </button>
                    <a href="{{ route($resource.'.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/jquery/jquery-3-7-1.min.js') }}"></script>
    <script type="text/javascript">        
        // Initialize Flatpickr for datetime fields
        flatpickr('#upload_time, #download_time, #account_upload_time', {
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
            time_24hr: true,
        });

        // Set current timestamp for employee_timestamp
        document.getElementById('employee_timestamp').value = new Date().toISOString().slice(0, 16);
    </script>
@endpush
