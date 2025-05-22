@extends('layouts.app')

@section('title', 'Add Offence')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datapicker/flatpickr.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/package/dist/sweetalert2.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/css/components/create-edit-page.css') }}" as="style">
@endpush

@section('content')
    <div class="max-w-8xl mx-auto sm:px-4 lg:px-1 py-2">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg px-2 py-4">
            <h1 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                <i class="fas fa-plus mr-2"></i> Add New Offence
            </h1>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-md mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('offences.store') }}" enctype="multipart/form-data" id="offence-form"
                class="space-y-2 px-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Offence Information -->
                    <div class="space-y-4 pr-8">
                        <h2 class="text-lg font-semibold text-gray-900">Offence Information</h2>
                        <!-- Driver Selection -->
                        <div>
                            <label for="driver_id" class="block text-sm font-medium text-gray-700">Driver <span
                                    class="text-red-500">*</span></label>
                            <select name="driver_id" id="driver_id"
                                class="select2 block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                required>
                                <option value="">Search Driver by ID</option>
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}"
                                        {{ old('driver_id') == $driver->id ? 'selected' : '' }}
                                        data-driver-details='{{ json_encode([
                                            'full_name' => $driver->full_name,
                                            'id_no' => $driver->id_no,
                                            'driving_license_no' => $driver->driving_license_no ?? 'N/A',
                                        ]) }}'>
                                        {{ $driver->id_no }} | {{ $driver->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500">Search driver by ID number</p>
                        </div>

                        <!-- Driver Details -->
                        <div id="driver-details"
                            class="hidden bg-gray-100 p-4 rounded-md border-l-4 border-blue-500 text-sm text-gray-700">
                            <p><strong>Driver Name:</strong> <span id="driver-name"></span></p>
                            <p><strong>Driver ID:</strong> <span id="driver-id-display"></span></p>
                            <p><strong>License No:</strong> <span id="driver-license"></span></p>
                        </div>

                        <!-- Offence Type -->
                        <x-form.input-group name="offence_type" label="Offence Type" type="select" required
                            :options="collect(App\Models\Offence::getOffenceTypeLabels())->map(
                                fn($label, $value) => [
                                    'value' => $value,
                                    'label' => $label,
                                    'selected' => old('offence_type') === (string) $value,
                                ],
                            )" hint="Select offence type"
                            extra-attributes="class='block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50'" />

                        <!-- Occurrence Date -->
                        <x-form.input-group name="occurrence_date" id="occurrence_date" label="Occurrence Date"
                            type="date" required max="{{ now()->format('Y-m-d') }}"
                            hint="Date of the offence (max date today)" :value="old('occurrence_date')"
                            extra-attributes="class='flatpickr block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50'" />

                        <!-- Description -->
                        <x-form.input-group name="description" label="Description" type="textarea" required minlength="2"
                            maxlength="250" rows="4" id="description"
                            extra-attributes="class='block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50'"
                            hint="" :value="old('description')" />
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>Minimum 2 and maximum 250 characters</span>
                            <span id="description-counter">0/250</span>
                        </div>
                    </div>

                    <!-- Complainant Information -->
                    <div class="space-y-4 pl-8">
                        <h2 class="text-lg font-semibold text-gray-900">Complainant Information</h2>

                        <!-- Complainant Name -->
                        <x-form.input-group name="complainant_name" label="Complainant Name" type="text" minlength="4"
                            maxlength="150" pattern="^[A-Za-z\s\.]+$"
                            title="4–150 characters, letters, spaces, periods only"
                            hint="Only letters, spaces, and periods allowed. Min 4, max 150 characters. e.g., John Doe"
                            :value="old('complainant_name')"
                            extra-attributes="class='block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50'" />

                        <!-- Complainant Phone -->
                        <x-form.input-group name="complainant_phone" label="Complainant Phone Number" type="tel"
                            pattern="[0-9]{6,11}" maxlength="11" placeholder="e.g., 1789012345" title="Enter 6 to 11 digits"
                            hint="Enter 6 to 11 digits (numbers only)" :value="old('complainant_phone')"
                            extra-attributes="class='block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50'" />

                        <!-- Attachments -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Attachments <span
                                    class="text-xs text-gray-500">(Max. 5)</span></label>
                            <div id="attachment-group" class="space-y-4 mt-2">
                                <div class="attachment-item flex flex-col sm:flex-row gap-4" data-index="0">
                                    <div class="flex-1">
                                        <input type="file" name="complainant_attachments[]"
                                            accept=".jpg,.jpeg,.png,.gif,.pdf"
                                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <p class="mt-1 text-xs text-gray-500">Images: JPG, PNG, GIF (Max 512KB), PDFs (Max
                                            1MB)</p>
                                        <div class="file-info text-xs text-gray-600 mt-2"></div>
                                        <div class="file-preview mt-2"></div>
                                    </div>
                                    <button type="button"
                                        class="action-btn bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700 hidden sm:self-start"
                                        data-action="remove">
                                        <i class="fas fa-trash mr-1"></i> Remove
                                    </button>
                                </div>
                            </div>
                            <button type="button"
                                class="action-btn bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 mt-2"
                                id="add-attachment">
                                <i class="fas fa-plus mr-1"></i> Add Attachment
                            </button>
                            <p class="text-red-500 text-xs mt-2 hidden" id="attachment-error">At least one valid
                                attachment
                                is required.</p>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-4">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-1 rounded-md hover:bg-blue-700">Submit</button>
                    <a href="{{ route('offences.index') }}"
                        class="bg-gray-300 text-gray-700 px-4 py-1 rounded-md hover:bg-gray-400">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/jquery/jquery-3-7-1.min.js') }}" ></script>
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}" ></script>
    {{-- <script src="{{ asset('assets/vendor/datapicker/flatpickr.min.js') }}" ></script> --}}
    <script src="{{ asset('assets/vendor/sweetalert/package/dist/sweetalert2.min.js') }}" ></script>
    <script src="{{ asset('assets/js/offence-form.js') }}" ></script>
@endpush
