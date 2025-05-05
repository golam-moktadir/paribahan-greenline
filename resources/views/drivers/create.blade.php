@extends('layouts.app')

@section('title', 'Add Driver')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datapicker/flatpickr.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/css/drivers/driver-create.min.css') }}" as="style">
    <style>
        .file-preview {
            margin-top: 10px;
            max-width: 150px;
        }

        .file-preview img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .file-info {
            font-size: 0.9em;
            color: #555;
            margin-top: 5px;
        }

        .file-info p {
            margin: 2px 0;
        }

        .error-text {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .char-counter {
            font-size: 0.9em;
            color: #555;
        }
    </style>
@endpush

@section('content')
    <div class="form-container">
        <div class="card">
            <h1 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Add New Driver</h1>

            @if ($errors->any())
                <div class="error-message alert alert-danger">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('drivers.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <!-- Column 1: Employment & Personal Information -->
                    <div>
                        <!-- Employment Information -->
                        <div>
                            <h2 class="section-title">Employment Information</h2>
                            <x-form.input-group name="" label="Transport Name" type="select" disabled
                                :options="$transports
                                    ->map(
                                        fn($t) => [
                                            'value' => $t->transport_id,
                                            'label' => $t->transport_name ?? 'Transport ' . $t->transport_id,
                                            'selected' => old('transport_id', 37) == $t->transport_id,
                                        ],
                                    )
                                    ->prepend(['value' => '', 'label' => 'Select Transport'])" hint="Select provider" />

                            <!-- Hidden input  -->
                            <input type="hidden" name="transport_id" value="{{ old('transport_id', 37) }}" />

                            <x-form.input-group name="department_id" label="Department" type="select" required
                                :options="$departments
                                    ->map(
                                        fn($d) => [
                                            'value' => $d->department_id,
                                            'label' => $d->department_name ?? 'Department ' . $d->department_id,
                                            'selected' => old('department_id') == $d->department_id,
                                        ],
                                    )
                                    ->prepend(['value' => '', 'label' => 'Select Department'])" hint="Choose department" />

                            <x-form.input-group name="status" label="Status" type="select" required :options="collect(\App\Models\Driver::STATUSES)->map(
                                fn($label, $value) => [
                                    'value' => $value,
                                    'label' => $label,
                                    'selected' => old('status', 'active') == $value,
                                ],
                            )"
                                hint="Select status" />

                        </div>

                        <!-- Personal Information -->
                        <div class="mt-2">
                            <h2 class="section-title">Personal Information</h2>
                            <x-form.input-group name="full_name" label="Full Name" type="text" required minlength="4"
                                maxlength="255" pattern="^[A-Za-z. ]+$" title="4–255 characters, letters, spaces, periods"
                                hint="e.g., John Doe" :value="old('full_name')" />
                            <x-form.input-group name="father_name" label="Father's Name" type="text" required
                                minlength="4" maxlength="255" pattern="^[A-Za-z. ]+$"
                                title="4–255 characters, letters, spaces, periods" hint="e.g., Michael Smith"
                                :value="old('father_name')" />
                            <x-form.input-group name="phone" label="Phone Number" type="tel" required
                                pattern="0[0-9]{9,10}" maxlength="11" placeholder="01789012345"
                                title="10-11 digits starting with 0" hint="e.g., 01789012345" :value="old('phone')" />
                            <x-form.input-group name="birth_date" id="birth_date" label="Date of Birth" type="date"
                                required max="{{ \Carbon\Carbon::now()->subYears(15)->format('Y-m-d') }}"
                                extra-attributes="onchange=validateJoiningDate()" hint="15+ years old" :value="old('birth_date')" />
                        </div>
                    </div>

                    <!-- Column 2: Identification & Attachments -->
                    <div>
                        <!-- Identification -->
                        <div>
                            <h2 class="section-title">Identification</h2>
                            <x-form.input-group name="nid_no" label="NID No." type="text" minlength="8" maxlength="20"
                                pattern="[0-9]+" title="8–20 digits" hint="e.g., 1234567890" :value="old('nid_no')" />
                            <x-form.input-group name="driving_license_no" label="Driving License No." type="text"
                                minlength="8" maxlength="20" pattern="[A-Z0-9]+" title="8–20 alphanumeric characters"
                                hint="e.g., DL12345678" :value="old('driving_license_no')" />
                            <x-form.input-group name="insurance_no" label="Insurance No." type="text" minlength="8"
                                maxlength="20" pattern="[A-Z0-9]+" title="8–20 alphanumeric characters"
                                hint="e.g., INS123456" :value="old('insurance_no')" />
                        </div>

                        <!-- Attachments -->
                        <div class="mt-2">
                            <h2 class="section-title">Attachments</h2>
                            <div>
                                <x-form.file-input name="avatar_url" label="Profile Photo" accept=".jpg,.jpeg,.png,.webp"
                                    hint="JPG/PNG, max 512KB" />
                                <div class="file-preview">
                                    <img id="avatar_url_preview" class="hidden" alt="Profile Photo Preview">
                                    <div id="avatar_url_info" class="file-info hidden">
                                        <p><strong>File Size:</strong> <span id="avatar_url_size"></span> KB</p>
                                        <p><strong>Resolution:</strong> <span id="avatar_url_resolution"></span></p>
                                        <p><strong>File Type:</strong> <span id="avatar_url_type"></span></p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <x-form.file-input name="nid_attachment" label="NID Scan" accept=".jpg,.jpeg,.png,.pdf"
                                    hint="JPG/PNG/PDF, max 512KB" />
                                <div class="file-preview">
                                    <img id="nid_attachment_preview" class="hidden" alt="NID Scan Preview">
                                    <div id="nid_attachment_info" class="file-info hidden">
                                        <p><strong>File Size:</strong> <span id="nid_attachment_size"></span> KB</p>
                                        <p><strong>Resolution:</strong> <span id="nid_attachment_resolution"></span></p>
                                        <p><strong>File Type:</strong> <span id="nid_attachment_type"></span></p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <x-form.file-input name="driving_license_attachment" label="Driving License Scan"
                                    accept=".jpg,.jpeg,.png,.pdf" hint="JPG/PNG/PDF, max 512KB" />
                                <div class="file-preview">
                                    <img id="driving_license_attachment_preview" class="hidden"
                                        alt="Driving License Scan Preview">
                                    <div id="driving_license_attachment_info" class="file-info hidden">
                                        <p><strong>File Size:</strong> <span id="driving_license_attachment_size"></span>
                                            KB
                                        </p>
                                        <p><strong>Resolution:</strong> <span
                                                id="driving_license_attachment_resolution"></span></p>
                                        <p><strong>File Type:</strong> <span id="driving_license_attachment_type"></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <x-form.file-input name="insurance_attachment" label="Insurance Document"
                                    accept=".jpg,.jpeg,.png,.pdf" hint="JPG/PNG/PDF, max 512KB" />
                                <div class="file-preview">
                                    <img id="insurance_attachment_preview" class="hidden"
                                        alt="Insurance Document Preview">
                                    <div id="insurance_attachment_info" class="file-info hidden">
                                        <p><strong>File Size:</strong> <span id="insurance_attachment_size"></span> KB</p>
                                        <p><strong>Resolution:</strong> <span id="insurance_attachment_resolution"></span>
                                        </p>
                                        <p><strong>File Type:</strong> <span id="insurance_attachment_type"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Work Info & Addresses -->
                    <div>
                        <!-- Work Information -->
                        <div>
                            <h2 class="section-title">Work Information</h2>
                            <x-form.input-group name="joining_date" id="joining_date" label="Joining Date"
                                type="date" required extra-attributes="onchange=validateJoiningDate()"
                                hint="Must be at least 15 years after birth date" :value="old('joining_date')" />
                            <p id="date-error" class="error-text hidden">
                                Joining date must be at least 15 years after the birth date.
                            </p>
                            <x-form.input-group name="reference" label="Reference" type="text" minlength="3"
                                maxlength="100" hint="e.g., Jane Smith" :value="old('reference')" />
                            <x-form.input-group name="pre_experience" label="Previous Experience (Years)" type="number"
                                min="0" max="50" step="1" hint="0–50 years" :value="old('pre_experience', 0)" />
                        </div>

                        <!-- Addresses -->
                        <div class="mt-2">
                            <h2 class="section-title">Addresses</h2>
                            <x-form.input-group name="present_address" label="Present Address" type="textarea" required
                                maxlength="255" rows="2" id="present_address"
                                extra-attributes="oninput=updateCharCount('present_address', 'present_address_counter')"
                                hint="Max 255 characters" :value="old('present_address')" />
                            <div class="char-counter">
                                <span id="present_address_counter">{{ strlen(old('present_address', '')) }}</span>/255
                            </div>
                            <x-form.input-group name="permanent_address" label="Permanent Address" type="textarea"
                                required maxlength="255" rows="2" id="permanent_address"
                                extra-attributes="oninput=updateCharCount('permanent_address', 'permanent_address_counter')"
                                hint="Max 255 characters" :value="old('permanent_address')" />
                            <div class="char-counter">
                                <span id="permanent_address_counter">{{ strlen(old('permanent_address', '')) }}</span>/255
                            </div>
                        </div>
                    </div>
                </div>

                <x-form.form-actions />
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/datapicker/flatpickr.min.js') }}"></script>
    <script>
        function loadFlatpickr() {
            // Check if Flatpickr CSS is already loaded to avoid duplicates
            if (!document.querySelector('link[href*="flatpickr.min.css"]')) {
                const link = document.createElement('link');
                link.rel = 'stylesheet';
                link.href = "{{ asset('assets/vendor/datapicker/flatpickr.min.css') }}";
                document.head.appendChild(link);
            }

            // Load Flatpickr script only if not already loaded
            if (typeof flatpickr === 'undefined') {
                const script = document.createElement('script');
                script.src = "{{ asset('assets/vendor/datapicker/flatpickr.min.js') }}";
                script.async = true;
                script.onload = initializeFlatpickr;
                document.body.appendChild(script);
            } else {
                initializeFlatpickr();
            }
        }

        function initializeFlatpickr() {
            let joiningDatePicker;

            // Birth date picker (minimum 15 years ago, maximum 100 years ago)
            const birthDatePicker = flatpickr('#birth_date', {
                dateFormat: 'Y-m-d',
                maxDate: '{{ \Carbon\Carbon::now()->subYears(15)->format('Y-m-d') }}',
                minDate: '{{ \Carbon\Carbon::now()->subYears(100)->format('Y-m-d') }}',
                onChange: function(selectedDates) {
                    if (selectedDates.length > 0) {
                        const birthDate = new Date(selectedDates[0]);
                        const minJoiningDate = new Date(birthDate.setFullYear(birthDate.getFullYear() + 15));

                        // Update joining date picker's minDate
                        joiningDatePicker.set('minDate', minJoiningDate);
                        joiningDatePicker.set('maxDate', null);

                        // Clear joining date if it’s before the new minDate
                        if (joiningDatePicker.selectedDates.length > 0 &&
                            joiningDatePicker.selectedDates[0] < minJoiningDate) {
                            joiningDatePicker.clear();
                        }

                        validateJoiningDate();
                    }
                }
            });

            // Joining date picker
            joiningDatePicker = flatpickr('#joining_date', {
                dateFormat: 'Y-m-d',
                minDate: '{{ \Carbon\Carbon::now()->subYears(15)->format('Y-m-d') }}',
                onChange: validateJoiningDate
            });
        }

        function updateCharCount(id, counterId) {
            const textarea = document.getElementById(id);
            const counter = document.getElementById(counterId);
            if (textarea && counter) {
                counter.textContent = textarea.value.length;
            }
        }

        function validateJoiningDate() {
            const birthDateInput = document.getElementById('birth_date');
            const joiningDateInput = document.getElementById('joining_date');
            const errorText = document.getElementById('date-error');

            if (birthDateInput.value && joiningDateInput.value) {
                const birthDate = new Date(birthDateInput.value);
                const joiningDate = new Date(joiningDateInput.value);
                const minJoiningDate = new Date(birthDate.setFullYear(birthDate.getFullYear() + 15));

                const isValid = joiningDate >= minJoiningDate;
                errorText.classList.toggle('hidden', isValid);
                joiningDateInput.setCustomValidity(isValid ? '' :
                    'Joining date must be at least 15 years after birth date.');
            } else {
                errorText.classList.add('hidden');
                joiningDateInput.setCustomValidity('');
            }
        }

        function resizeImage(file, maxWidth, maxHeight, maxSizeKB, callback) {
            if (!file.type.startsWith('image/')) {
                callback(file, 0, 0); // Pass through non-image files
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    let width = img.width;
                    let height = img.height;

                    // Skip resizing if already within limits
                    if (width <= maxWidth && height <= maxHeight && file.size <= maxSizeKB * 1024) {
                        callback(file, width, height);
                        return;
                    }

                    // Calculate new dimensions while maintaining aspect ratio
                    if (width > height) {
                        if (width > maxWidth) {
                            height = Math.round((height * maxWidth) / width);
                            width = maxWidth;
                        }
                    } else {
                        if (height > maxHeight) {
                            width = Math.round((width * maxHeight) / height);
                            height = maxHeight;
                        }
                    }

                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    // Convert to JPEG with quality adjustment
                    let quality = 0.9;
                    let dataUrl;
                    do {
                        dataUrl = canvas.toDataURL('image/jpeg', quality);
                        const sizeKB = ((dataUrl.length * 3) / 4 / 1024).toFixed(2);
                        if (sizeKB <= maxSizeKB) break;
                        quality -= 0.1;
                    } while (quality > 0.1);

                    // Convert data URL to Blob
                    fetch(dataUrl)
                        .then(res => res.blob())
                        .then(blob => callback(blob, width, height))
                        .catch(() => callback(file, img.width, img.height)); // Fallback to original
                };
                img.onerror = () => callback(file, 0, 0); // Handle corrupt images
                img.src = e.target.result;
            };
            reader.onerror = () => callback(file, 0, 0);
            reader.readAsDataURL(file);
        }

        function previewFile(inputId, previewId, infoId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const info = document.getElementById(infoId);
            const sizeSpan = document.getElementById(`${inputId}_size`);
            const resolutionSpan = document.getElementById(`${inputId}_resolution`);
            const typeSpan = document.getElementById(`${inputId}_type`);

            // Reset preview if no file is selected
            if (!input.files || !input.files[0]) {
                preview.src = '#';
                preview.classList.add('hidden');
                info.classList.add('hidden');
                sizeSpan.textContent = '';
                resolutionSpan.textContent = '';
                typeSpan.textContent = '';
                input.setCustomValidity('');
                return;
            }

            const file = input.files[0];
            const maxSize = 524288; // 512 KB in bytes
            const fileType = file.type;
            const isImage = fileType.startsWith('image/');
            const isPDF = fileType === 'application/pdf';
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];

            // Validate file type
            if (!allowedTypes.includes(fileType)) {
                alert('Invalid file type. Please upload JPG, PNG, WEBP, or PDF.');
                input.value = '';
                input.setCustomValidity('Invalid file type.');
                preview.src = '#';
                preview.classList.add('hidden');
                info.classList.add('hidden');
                sizeSpan.textContent = '';
                resolutionSpan.textContent = '';
                typeSpan.textContent = '';
                return;
            }

            // Validate file size
            if (file.size > maxSize) {
                alert(`File size exceeds 512KB. Please choose a smaller file.`);
                input.value = '';
                input.setCustomValidity('File size exceeds 512KB.');
                preview.src = '#';
                preview.classList.add('hidden');
                info.classList.add('hidden');
                sizeSpan.textContent = '';
                resolutionSpan.textContent = '';
                typeSpan.textContent = '';
                return;
            }

            // Process file
            if (isImage) {
                resizeImage(file, 1024, 1024, 512, (resizedBlob, width, height) => {
                    const url = URL.createObjectURL(resizedBlob);
                    preview.src = url;
                    preview.classList.remove('hidden');
                    info.classList.remove('hidden');

                    // Update file info
                    const sizeKB = (resizedBlob.size / 1024).toFixed(2);
                    sizeSpan.textContent = sizeKB;
                    resolutionSpan.textContent = `${width}x${height}`;
                    typeSpan.textContent = resizedBlob.type.split('/')[1].toUpperCase();

                    // Replace input file with resized blob
                    const newFile = new File([resizedBlob], file.name, {
                        type: resizedBlob.type
                    });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(newFile);
                    input.files = dataTransfer.files;
                    input.setCustomValidity('');
                });
            } else if (isPDF) {
                preview.src = '#';
                preview.classList.add('hidden');
                info.classList.remove('hidden');

                const sizeKB = (file.size / 1024).toFixed(2);
                sizeSpan.textContent = sizeKB;
                resolutionSpan.textContent = 'N/A (PDF)';
                typeSpan.textContent = 'PDF';
                input.setCustomValidity('');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadFlatpickr();

            // Initialize character counters for address fields
            ['present_address', 'permanent_address'].forEach(id => {
                const textarea = document.getElementById(id);
                if (textarea) {
                    updateCharCount(id, `${id}_counter`);
                    textarea.addEventListener('input', () => updateCharCount(id, `${id}_counter`));
                }
            });

            // Attach file preview listeners
            ['avatar_url', 'nid_attachment', 'driving_license_attachment', 'insurance_attachment'].forEach(id =>
                document.getElementById(id)?.addEventListener('change', () => previewFile(id, `${id}_preview`,
                    `${id}_info`))
            );
        });
    </script>
@endpush
