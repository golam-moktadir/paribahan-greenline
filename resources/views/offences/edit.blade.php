@extends('layouts.app')

@section('title', 'Edit ' . ($featureName ?? 'Offence') . ' #' . ($offence->id ?? 'N/A'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datapicker/flatpickr.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/package/dist/sweetalert2.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/css/components/edit-page.css') }}" as="style">
@endpush

@section('content')
    <div class="container mx-auto p-2">
        <div class="card shadow-sm">
            <!-- Header -->
            <div class="flex flex-col sm:flex-row items-center justify-between mb-4 gap-4">
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fas fa-pencil text-gray-500"></i>
                    Offence #{{ $offence->id }} - {{ $offence->driver->full_name ?? 'N/A' }}
                </h1>
                <div class="flex gap-3">
                    <a href="{{ route('offences.index') }}" class="action-btn back-btn">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </a>
                </div>
            </div>

            <div class="card-body p-2">
                @if ($errors->any())
                    <div class="error-message">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('offences.update', $offence->id) }}" enctype="multipart/form-data"
                    id="offence-form">
                    @csrf
                    @method('PUT')
                    <div class="form-grid shadow-lg p-2">
                        <div>
                            <section>
                                <h2 class="section-title">Offence Information</h2>

                                <div class="mb-3">
                                    <label for="driver_id" class="form-label">Driver <span
                                            class="text-danger">*</span></label>
                                    <select name="driver_id" id="driver_id" class="select2 form-control" required>
                                        <option value="">Search Driver by ID</option>
                                        @foreach ($drivers as $driver)
                                            <option value="{{ $driver->id }}"
                                                {{ old('driver_id', $offence->driver_id ?? '') == $driver->id ? 'selected' : '' }}
                                                data-driver-details="{{ json_encode([
                                                    'full_name' => $driver->full_name,
                                                    'id_no' => $driver->id_no,
                                                    'driving_license_no' => $driver->driving_license_no ?? 'N/A',
                                                ]) }}">
                                                {{ $driver->id_no }} | {{ $driver->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="form-hint">Search driver by ID number.</p>
                                </div>

                                <div class="driver-details {{ !old('driver_id', $offence->driver_id ?? false) ? 'hidden' : '' }}"
                                    id="driver-details">
                                    <p><strong>Name:</strong> <span
                                            id="driver-name">{{ $offence->driver->full_name ?? '' }}</span></p>
                                    <p><strong>ID No.:</strong> <span
                                            id="driver-id-display">{{ $offence->driver->id_no ?? '' }}</span></p>
                                    <p><strong>Driving License:</strong> <span
                                            id="driver-license">{{ $offence->driver->driving_license_no ?? 'N/A' }}</span>
                                    </p>
                                </div>

                                <div class="mt-3">
                                    <label for="offence_type" class="form-label">Offence Type <span
                                            class="text-danger">*</span></label>
                                    <select name="offence_type" id="offence_type" class="form-control" required>
                                        <option value="">Select Offence Type</option>
                                        @foreach (App\Models\Offence::getOffenceTypeLabels() as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ old('offence_type', $offence->offence_type ?? '') === $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="form-hint">Select the type of offence committed.</p>
                                </div>

                                <div class="mt-3">
                                    <label for="occurrence_date" class="form-label">Occurrence Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control flatpickr" id="occurrence_date"
                                        name="occurrence_date"
                                        value="{{ old('occurrence_date', $offence->occurrence_date ? $offence->occurrence_date->format('Y-m-d') : '') }}"
                                        required max="{{ now()->format('Y-m-d') }}">
                                    <p class="form-hint">Date when the offence occurred (cannot be in the future).</p>
                                </div>

                                <div class="mt-3">
                                    <label for="description" class="form-label">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" id="description" name="description" rows="4" maxlength="255" required
                                        oninput="updateCharCount('description', 'description-counter')">{{ $offence->description ?? old('description') }}</textarea>
                                    <p class="form-hint">Provide a brief description of the offence (max 255 characters).
                                    </p>
                                    <div class="char-counter" id="description-counter">
                                        {{ strlen($offence->description ?? old('description')) }}/255
                                    </div>
                                </div>
                        </div>

                        <div>
                            <section>
                                <h2 class="section-title">Complainant Details</h2>
                                <div class="mb-3">
                                    <label for="complainant_name" class="form-label">Complainant Name</label>
                                    <input type="text" class="form-control" id="complainant_name" name="complainant_name"
                                        value="{{ $offence->complainant_name ?? old('complainant_name') }}" minlength="4"
                                        maxlength="255" pattern="^[A-Za-z. ]+$"
                                        title="4–255 characters, letters, spaces, periods"
                                        placeholder="Enter complainant's name">
                                    <p class="form-hint">Full name of the complainant (if applicable).</p>
                                </div>

                                <div class="mb-3">
                                    <label for="complainant_phone" class="form-label">Complainant Phone Number</label>
                                    <input type="tel" class="form-control" id="complainant_phone"
                                        name="complainant_phone"
                                        value="{{ $offence->complainant_phone ?? old('complainant_phone') }}"
                                        pattern="[0-9]{6,11}" maxlength="11" placeholder="e.g., 017xxxxxxxx"
                                        title="6-11 digits">
                                    <p class="form-hint">Phone number of the complainant.</p>
                                </div>
                            </section>

                            <section class="mt-4">
                                <h2 class="section-title">Attachments</h2>
                                @if ($offence->attachments && count($offence->attachments) > 0)
                                    <div class="current-attachments">
                                        <h4>Current Attachments</h4>
                                        @foreach ($offence->attachments as $index => $attachment)
                                            <div class="current-attachment-item flex items-center justify-between mb-2">
                                                <div class="flex items-center gap-3">
                                                    <i class="fas fa-file"></i>

                                                    @php
                                                        $fileExtension = strtolower(
                                                            pathinfo($attachment->path, PATHINFO_EXTENSION),
                                                        );
                                                        $isImage = in_array($fileExtension, [
                                                            'jpg',
                                                            'jpeg',
                                                            'png',
                                                            'gif',
                                                        ]);
                                                    @endphp

                                                    @if ($isImage)
                                                        <a href="{{ asset($attachment->path) }}" target="_blank">
                                                            <img src="{{ asset($attachment->path) }}" alt="Image"
                                                                class="thumbnail w-16 h-16 object-cover rounded" />
                                                        </a>
                                                    @elseif ($fileExtension === 'pdf')
                                                        <a href="{{ asset($attachment->path) }}" target="_blank"
                                                            class="flex items-center space-x-2 text-red-600">
                                                            <i class="fas fa-file-pdf"></i><span>Click to view PDF</span>
                                                        </a>
                                                    @else
                                                        <a href="{{ asset($attachment->path) }}" target="_blank"
                                                            class="flex items-center space-x-2">
                                                            <i class="fas fa-file-alt"></i><span>Click to view</span>
                                                        </a>
                                                    @endif
                                                </div>

                                                {{-- <form
                                                    action="{{ route('offences.attachmentDelete', [$offence->id, $attachment->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this attachment?');"
                                                    class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger text-sm px-3 py-1 ml-4">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </form> --}}

                                            </div>
                                        @endforeach

                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="complainant_attachments" class="form-label">Add More Attachments (Max
                                        {{ 5 - ($offence->attachments ? count($offence->attachments) : 0) }} more)</label>
                                    <div id="attachment-group">
                                        @if (!$offence->attachments || count($offence->attachments) === 0)
                                            <div class="attachment-item" data-index="0">
                                                <div class="attachment-input">
                                                    <input type="file" name="complainant_attachments[]"
                                                        accept=".jpg,.jpeg,.png,.gif,.pdf" class="form-control">
                                                    <p class="form-hint">JPG, PNG, GIF, PDF (Max 512KB each).</p>
                                                    <div id="file-info-0" class="file-info"></div>
                                                    <div id="file-preview-0" class="file-preview"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    @if (!$offence->attachments || count($offence->attachments) < 5)
                                        <button type="button"
                                            class="action-btn bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 mt-2"
                                            id="add-attachment">
                                            <i class="fas fa-plus mr-2"></i> Add More Attachments
                                        </button>
                                    @endif
                                    <p class="error-text hidden" id="attachment-error">At least one attachment is
                                        required.
                                    </p>
                                </div>
                            </section>

                            <!-- Form Actions -->
                            <div class="flex justify-end gap-4">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-4 py-1 rounded-md hover:bg-blue-700">Update</button>
                                <a href="{{ route('offences.index') }}"
                                    class="bg-gray-300 text-gray-700 px-4 py-1 rounded-md hover:bg-gray-400">Cancel</a>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/jquery/jquery-3-7-1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datapicker/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/package/dist/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for driver selection
            $('.select2').select2();

            // Initialize Flatpickr for date input
            $('.flatpickr').flatpickr({
                dateFormat: "Y-m-d",
                maxDate: new Date(), // Ensure date is not in the future
            });

            // Function to update character count for description
            window.updateCharCount = function(inputId, counterId) {
                const input = document.getElementById(inputId);
                const counter = document.getElementById(counterId);
                if (input && counter) {
                    const maxLength = parseInt(input.getAttribute('maxlength')) || 250;
                    counter.textContent = `${input.value.length}/${maxLength}`;
                }
            };

            // Initialize character count on page load
            updateCharCount('description', 'description-counter');

            // Event listener for driver selection to display details
            $('#driver_id').on('change', function() {
                const driverDetails = $(this).find(':selected').data('driver-details');
                const driverDetailsDiv = $('#driver-details');
                if (driverDetails) {
                    $('#driver-name').text(driverDetails.full_name);
                    $('#driver-id-display').text(driverDetails.id_no);
                    $('#driver-license').text(driverDetails.driving_license_no || 'N/A');
                    driverDetailsDiv.removeClass('hidden');
                } else {
                    driverDetailsDiv.addClass('hidden');
                }
            });

            // Function to preview selected file and display info
            function previewFile(input, index) {
                const file = input.files[0];
                const fileInfoDiv = $('#file-info-' + index);
                const filePreviewDiv = $('#file-preview-' + index);

                fileInfoDiv.empty();
                filePreviewDiv.empty();

                if (file) {
                    const fileSizeKB = (file.size / 1024).toFixed(2);
                    fileInfoDiv.html(
                        `<p><strong>File:</strong> ${file.name}</p><p><strong>Size:</strong> ${fileSizeKB} KB</p>`
                    );

                    const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
                    if (allowedTypes.includes(file.type)) {
                        if (file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                filePreviewDiv.html(
                                    `<img src="${e.target.result}" alt="Preview" style="max-width: 100px; height: auto;">`
                                );
                            }
                            reader.readAsDataURL(file);
                        } else if (file.type === 'application/pdf') {
                            filePreviewDiv.html(
                                '<i class="fas fa-file-pdf" style="font-size: 2em; color: #dc3545;"></i> PDF File'
                            );
                        }
                    } else {
                        alert('Invalid file type. Please upload JPG, PNG, GIF, or PDF.');
                        $(input).val(''); // Clear the invalid file
                    }
                }
            }

            function updateAddAttachmentButtonVisibility() {
                const currentAttachmentCount = $('.current-attachments .current-attachment-item').length;
                const newAttachmentCount = $('#attachment-group').children('.attachment-item').length;
                const totalAttachments = currentAttachmentCount + newAttachmentCount;

                if (totalAttachments < 5) {
                    $('#add-attachment').show();
                } else {
                    $('#add-attachment').hide();
                }
            }

            function reIndexAttachmentFields() {
                $('#attachment-group').children('.attachment-item').each(function(index) {
                    $(this).attr('data-index', index);
                    $(this).find('.attachment-input input').attr('id', 'complainant_attachments_' + index);
                    $(this).find('.file-info').attr('id', 'file-info-' + index);
                    $(this).find('.file-preview').attr('id', 'file-preview-' + index);
                });
            }

            // Initial call to set visibility
            updateAddAttachmentButtonVisibility();

            // Initialize preview for existing attachments on edit page and attach change event
            $('#attachment-group input[type="file"]').each(function(index) {
                $(this).on('change', function() {
                    previewFile(this, index);
                });
            });

            // Handle adding new attachment fields
            $('#add-attachment').on('click', function() {
                const attachmentGroup = $('#attachment-group');
                const currentAttachmentCount = $('.current-attachments .current-attachment-item').length;
                const newAttachmentCount = attachmentGroup.children('.attachment-item').length;
                const totalAttachmentCount = currentAttachmentCount + newAttachmentCount;

                if (totalAttachmentCount < 5) {
                    const newIndex = newAttachmentCount;
                    const newItem = $('<div class="attachment-item" data-index="' + newIndex + '">' +
                        '<div class="attachment-input">' +
                        '<input type="file" name="complainant_attachments[]" id="complainant_attachments_' +
                        newIndex + '" accept=".jpg,.jpeg,.png,.gif,.pdf" class="form-control">' +
                        '<p class="form-hint">JPG, PNG, GIF, PDF (Max 512KB each).</p>' +
                        '<div id="file-info-' + newIndex + '" class="file-info"></div>' +
                        '<div id="file-preview-' + newIndex + '" class="file-preview"></div>' +
                        '</div>' +
                        '<button type="button" class="action-btn remove-btn mt-2">' +
                        '<i class="fas fa-trash"></i> Remove' +
                        '</button>' +
                        '</div>');
                    attachmentGroup.append(newItem);

                    // Re-initialize event listener for the new remove button
                    newItem.find('.remove-btn').on('click', function() {
                        $(this).closest('.attachment-item').remove();
                        updateAddAttachmentButtonVisibility();
                        reIndexAttachmentFields();
                    });

                    // Re-initialize file preview for the new input
                    newItem.find('input[type="file"]').on('change', function() {
                        previewFile(this, newIndex);
                    });
                    updateAddAttachmentButtonVisibility();
                } else {
                    alert('Maximum 5 attachments allowed.');
                }
            });

            // Handle removing attachment fields (for dynamically added ones)
            $('#attachment-group').on('click', '.remove-btn', function() {
                $(this).closest('.attachment-item').remove();
                updateAddAttachmentButtonVisibility();
                reIndexAttachmentFields();
            });

            // Basic client-side validation for at least one attachment before submit
            $('#offence-form').on('submit', function(e) {
                const attachmentCount = $('.current-attachments .current-attachment-item').length + $(
                    '#attachment-group').children('.attachment-item').length;
                const hasFiles = $('#attachment-group input[type="file"]').filter(function() {
                    return $(this).prop('files').length > 0;
                }).length;

                if (attachmentCount === 0 && !hasFiles) {
                    $('#attachment-error').removeClass('hidden').text(
                        'At least one attachment is required.');
                    e.preventDefault();
                } else {
                    $('#attachment-error').addClass('hidden').text('');
                }
            });
        });
    </script>
@endpush
