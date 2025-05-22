@extends('layouts.app')

@section('title', 'Edit Driver')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datapicker/flatpickr.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/css/components/create-edit-page.css') }}" as="style">

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

        [aria-live="polite"] {
            transition: opacity 0.3s ease;
        }

        .error-text:not(.hidden) {
            display: block;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .hidden {
            display: none;
        }
    </style>
@endpush

@section('content')
    <div class="form-container">
        <div class="card">
            <h1 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">
                <i class="fas fa-edit mr-2 text-gray-500"></i>
                Edit Driver: {{ $item->full_name }}
            </h1>

            @if ($errors->any())
                <div class="error-message alert alert-danger" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('drivers.update', $item->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                                            'selected' => $item->transport_id == $t->transport_id,
                                        ],
                                    )
                                    ->prepend(['value' => '', 'label' => 'Select Transport'])" hint="Select provider" />
                            <input type="hidden" name="transport_id" value="{{ $item->transport_id }}" />

                            <x-form.input-group name="department_id" label="Department" type="select" required
                                :options="$departments
                                    ->map(
                                        fn($d) => [
                                            'value' => $d->department_id,
                                            'label' => $d->department_name ?? 'Department ' . $d->department_id,
                                            'selected' => $item->department_id == $d->department_id,
                                        ],
                                    )
                                    ->prepend(['value' => '', 'label' => 'Select Department'])" hint="Choose department" />

                            <x-form.input-group name="status" label="Status" type="select" required :options="collect(\App\Models\Driver::STATUSES)->map(
                                fn($label, $value) => [
                                    'value' => $value,
                                    'label' => $label,
                                    'selected' => (string) $item->status === (string) $value,
                                ],
                            )"
                                hint="Select status" />

                            <x-form.input-group name="id_no" label="ID No." type="text" minlength="4" maxlength="20"
                                pattern="^[A-Z0-9]+$" title="4–20 uppercase letters and numbers" hint="e.g., DI1234"
                                :value="$item->id_no" />
                        </div>

                        <!-- Personal Information -->
                        <div class="mt-2">
                            <h2 class="section-title">Personal Information</h2>
                            <x-form.input-group name="full_name" label="Full Name" type="text" required minlength="4"
                                maxlength="255" pattern="^[A-Za-z. ]+$" title="4–255 characters, letters, spaces, periods"
                                hint="e.g., John Doe" :value="$item->full_name" />
                            <x-form.input-group name="father_name" label="Father's Name" type="text" required
                                minlength="4" maxlength="255" pattern="^[A-Za-z. ]+$"
                                title="4–255 characters, letters, spaces, periods" hint="e.g., Michael Smith"
                                :value="$item->father_name" />
                            <x-form.input-group name="phone" label="Phone Number" type="tel" required
                                pattern="0[0-9]{6,10}" maxlength="11" placeholder="01789012345"
                                title="6-11 digits starting with 0" hint="e.g., 01789012345" :value="$item->phone" />

                            <x-form.input-group name="birth_date" id="birth_date" label="Date of Birth" type="date"
                                required :max="\Carbon\Carbon::now()->subYears(15)->format('Y-m-d')" extra-attributes="onchange=validateJoiningDate()"
                                hint="Must be at least 15 years old" :value="old('birth_date', optional($item->birth_date)->format('Y-m-d'))" />


                            <div>
                                <x-form.file-input name="avatar_url" label="Profile Photo" accept=".jpg,.jpeg,.png,.gif"
                                    hint="JPG/PNG/GIF, max 512KB" />
                                <div class="file-preview" role="region" aria-live="polite">
                                    @if ($item->avatar_url)
                                        <img id="avatar_url_preview" src="{{ asset($item->avatar_url) }}"
                                            alt="Profile Photo Preview">
                                        <div id="avatar_url_info" class="file-info">
                                            <p><strong>File:</strong> Existing Profile Photo</p>
                                        </div>
                                    @else
                                        <img id="avatar_url_preview" class="hidden" alt="Profile Photo Preview">
                                        <div id="avatar_url_info" class="file-info hidden">
                                            <p><strong>File Size:</strong> <span id="avatar_url_size"></span> KB</p>
                                            <p><strong>Resolution:</strong> <span id="avatar_url_resolution"></span></p>
                                            <p><strong>File Type:</strong> <span id="avatar_url_type"></span></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2: Identification & Attachments -->
                    <div>
                        <!-- Identification -->
                        <div>
                            <h2 class="section-title">Identification</h2>
                            <x-form.input-group name="nid_no" label="NID No." type="text" minlength="8" maxlength="20"
                                required pattern="[0-9]+" title="8–20 digits" hint="e.g., 1234567890"
                                :value="$item->nid_no" />
                            <x-form.input-group name="driving_license_no" label="Driving License No." type="text"
                                minlength="8" maxlength="20" required pattern="[A-Z0-9]+"
                                title="8–20 alphanumeric characters" hint="e.g., DL12345678" :value="$item->driving_license_no" />
                            <x-form.input-group name="insurance_no" label="Insurance No." type="text" minlength="8"
                                maxlength="30" pattern="[A-Z0-9]+" title="8–30 alphanumeric characters"
                                hint="e.g., INS123456" :value="$item->insurance_no" />
                        </div>

                        <!-- Attachments -->
                        <div class="mt-2">
                            <h2 class="section-title">Attachments</h2>
                            <div>
                                <x-form.file-input name="nid_front_attachment" label="NID Front Scan"
                                    accept=".jpg,.jpeg,.png,.gif,.pdf" hint="JPG/PNG/GIF/PDF, max 512KB" />
                                <div class="file-preview" role="region" aria-live="polite">
                                    @if ($item->nid_front_attachment)
                                        <img id="nid_front_attachment_preview"
                                            src="{{ asset($item->nid_front_attachment) }}" alt="NID Front Scan Preview">
                                        <div id="nid_front_attachment_info" class="file-info">
                                            <p><strong>File:</strong> Existing NID Front Scan</p>
                                        </div>
                                    @else
                                        <img id="nid_front_attachment_preview" class="hidden"
                                            alt="NID Front Scan Preview">
                                        <div id="nid_front_attachment_info" class="file-info hidden">
                                            <p><strong>File Size:</strong> <span id="nid_front_attachment_size"></span> KB
                                            </p>
                                            <p><strong>Resolution:</strong> <span
                                                    id="nid_front_attachment_resolution"></span></p>
                                            <p><strong>File Type:</strong> <span id="nid_front_attachment_type"></span></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <x-form.file-input name="nid_back_attachment" label="NID Back Scan"
                                    accept=".jpg,.jpeg,.png,.gif,.pdf" hint="JPG/PNG/GIF/PDF, max 512KB" />
                                <div class="file-preview" role="region" aria-live="polite">
                                    @if ($item->nid_back_attachment)
                                        <img id="nid_back_attachment_preview"
                                            src="{{ asset($item->nid_back_attachment) }}" alt="NID Back Scan Preview">
                                        <div id="nid_back_attachment_info" class="file-info">
                                            <p><strong>File:</strong> Existing NID Back Scan</p>
                                        </div>
                                    @else
                                        <img id="nid_back_attachment_preview" class="hidden" alt="NID Back Scan Preview">
                                        <div id="nid_back_attachment_info" class="file-info hidden">
                                            <p><strong>File Size:</strong> <span id="nid_back_attachment_size"></span> KB
                                            </p>
                                            <p><strong>Resolution:</strong> <span
                                                    id="nid_back_attachment_resolution"></span></p>
                                            <p><strong>File Type:</strong> <span id="nid_back_attachment_type"></span></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <x-form.file-input name="driving_license_front_attachment"
                                    label="Driving License Front Scan" accept=".jpg,.jpeg,.png,.gif,.pdf"
                                    hint="JPG/PNG/GIF/PDF, max 512KB" />
                                <div class="file-preview" role="region" aria-live="polite">
                                    @if ($item->driving_license_front_attachment)
                                        <img id="driving_license_front_attachment_preview"
                                            src="{{ asset($item->driving_license_front_attachment) }}"
                                            alt="Driving License Front Scan Preview">
                                        <div id="driving_license_front_attachment_info" class="file-info">
                                            <p><strong>File:</strong> Existing Driving License Front Scan</p>
                                        </div>
                                    @else
                                        <img id="driving_license_front_attachment_preview" class="hidden"
                                            alt="Driving License Front Scan Preview">
                                        <div id="driving_license_front_attachment_info" class="file-info hidden">
                                            <p><strong>File Size:</strong> <span
                                                    id="driving_license_front_attachment_size"></span> KB</p>
                                            <p><strong>Resolution:</strong> <span
                                                    id="driving_license_front_attachment_resolution"></span></p>
                                            <p><strong>File Type:</strong> <span
                                                    id="driving_license_front_attachment_type"></span></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <x-form.file-input name="driving_license_back_attachment"
                                    label="Driving License Back Scan" accept=".jpg,.jpeg,.png,.gif,.pdf"
                                    hint="JPG/PNG/GIF/PDF, max 512KB" />
                                <div class="file-preview" role="region" aria-live="polite">
                                    @if ($item->driving_license_back_attachment)
                                        <img id="driving_license_back_attachment_preview"
                                            src="{{ asset($item->driving_license_back_attachment) }}"
                                            alt="Driving License Back Scan Preview">
                                        <div id="driving_license_back_attachment_info" class="file-info">
                                            <p><strong>File:</strong> Existing Driving License Back Scan</p>
                                        </div>
                                    @else
                                        <img id="driving_license_back_attachment_preview" class="hidden"
                                            alt="Driving License Back Scan Preview">
                                        <div id="driving_license_back_attachment_info" class="file-info hidden">
                                            <p><strong>File Size:</strong> <span
                                                    id="driving_license_back_attachment_size"></span> KB</p>
                                            <p><strong>Resolution:</strong> <span
                                                    id="driving_license_back_attachment_resolution"></span></p>
                                            <p><strong>File Type:</strong> <span
                                                    id="driving_license_back_attachment_type"></span></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <x-form.file-input name="insurance_attachment" label="Insurance Document"
                                    accept=".jpg,.jpeg,.png,.gif,.pdf" hint="JPG/PNG/GIF/PDF, max 512KB" />
                                <div class="file-preview" role="region" aria-live="polite">
                                    @if ($item->insurance_attachment)
                                        <img id="insurance_attachment_preview"
                                            src="{{ asset($item->insurance_attachment) }}"
                                            alt="Insurance Document Preview">
                                        <div id="insurance_attachment_info" class="file-info">
                                            <p><strong>File:</strong> Existing Insurance Document</p>
                                        </div>
                                    @else
                                        <img id="insurance_attachment_preview" class="hidden"
                                            alt="Insurance Document Preview">
                                        <div id="insurance_attachment_info" class="file-info hidden">
                                            <p><strong>File Size:</strong> <span id="insurance_attachment_size"></span> KB
                                            </p>
                                            <p><strong>Resolution:</strong> <span
                                                    id="insurance_attachment_resolution"></span></p>
                                            <p><strong>File Type:</strong> <span id="insurance_attachment_type"></span></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 3: Work Info & Addresses -->
                    <div>
                        <!-- Work Information -->
                        <div>
                            <h2 class="section-title">Work Information</h2>
                            <x-form.input-group name="pre_experience" label="Previous Experience (Years)" type="number"
                                min="0" max="75" step="1" required hint="0–75 years"
                                :value="$item->pre_experience" />
                            <x-form.input-group name="joining_date" id="joining_date" label="Joining Date"
                                type="date" required hint="Must be at least 15 years after birth date"
                                :value="old('joining_date', optional($item->joining_date)->format('Y-m-d'))" />
                            <p id="date-error" class="error-text hidden" role="alert">
                                Joining date must be at least 15 years after the birth date.
                            </p>


                            <x-form.input-group name="reference" label="Reference" type="text" minlength="4"
                                maxlength="100" required title="4–100 characters" hint="e.g., Jane Smith"
                                :value="$item->reference" />
                        </div>

                        <!-- Addresses -->
                        <div class="mt-2">
                            <h2 class="section-title">Addresses</h2>
                            <x-form.input-group name="present_address" label="Present Address" type="textarea" required
                                maxlength="255" rows="2" id="present_address" hint="Max 255 characters"
                                :value="$item->present_address" />
                            <div class="char-counter" aria-live="polite">
                                <span id="present_address_counter">{{ strlen($item->present_address) }}</span>/255
                            </div>
                            <x-form.input-group name="permanent_address" label="Permanent Address" type="textarea"
                                required maxlength="255" rows="2" id="permanent_address" hint="Max 255 characters"
                                :value="$item->permanent_address" />
                            <div class="char-counter" aria-live="polite">
                                <span id="permanent_address_counter">{{ strlen($item->permanent_address) }}</span>/255
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
    <script src="{{ asset('assets/vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Flatpickr for date pickers
            const birthDatePicker = flatpickr('#birth_date', {
                dateFormat: 'Y-m-d',
                maxDate: new Date().fp_incr(-15 * 365), // 15 years ago
                minDate: new Date().fp_incr(-100 * 365), // 100 years ago
                onChange: (selectedDates) => {
                    if (selectedDates.length > 0) {
                        const birthDate = new Date(selectedDates[0]);
                        const minJoiningDate = new Date(birthDate.setFullYear(birthDate.getFullYear() +
                            15));
                        joiningDatePicker.set('minDate', minJoiningDate);
                        joiningDatePicker.set('maxDate', new Date());
                        validateJoiningDate();
                    }
                },
                altInput: true,
                altFormat: 'F j, Y',
            });

            const joiningDatePicker = flatpickr('#joining_date', {
                dateFormat: 'Y-m-d',
                maxDate: new Date(),
                onChange: validateJoiningDate,
                altInput: true,
                altFormat: 'F j, Y',
            });

            // Character counter for textareas
            const updateCharCount = (textarea, counter) => {
                counter.textContent = textarea.value.length;
            };

            ['present_address', 'permanent_address'].forEach((id) => {
                const textarea = document.getElementById(id);
                const counter = document.getElementById(`${id}_counter`);
                if (textarea && counter) {
                    updateCharCount(textarea, counter);
                    textarea.addEventListener('input', () => updateCharCount(textarea, counter));
                }
            });

            // Date validation
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
                    joiningDateInput.setCustomValidity(
                        isValid ? '' : 'Joining date must be at least 15 years after birth date.'
                    );
                } else {
                    errorText.classList.add('hidden');
                    joiningDateInput.setCustomValidity('');
                }
            }

            // Image resizing
            function resizeImage(file, maxWidth, maxHeight, maxSizeKB, callback) {
                if (!file.type.startsWith('image/')) {
                    callback(file, 0, 0);
                    return;
                }

                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = new Image();
                    img.onload = () => {
                        let width = img.width;
                        let height = img.height;
                        const aspectRatio = width / height;

                        // Resize logic
                        if (width > maxWidth || height > maxHeight) {
                            if (aspectRatio >= 1) {
                                width = maxWidth;
                                height = Math.round(maxWidth / aspectRatio);
                            } else {
                                height = maxHeight;
                                width = Math.round(maxHeight * aspectRatio);
                            }
                        } else if (width < 600 || height < 800) {
                            if (aspectRatio >= 1) {
                                width = 800;
                                height = Math.round(800 / aspectRatio);
                            } else {
                                height = 800;
                                width = Math.round(800 * aspectRatio);
                            }
                        }

                        const canvas = document.createElement('canvas');
                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);

                        let quality = 0.9;
                        let dataUrl;
                        let sizeKB;

                        do {
                            dataUrl = canvas.toDataURL(file.type, quality);
                            sizeKB = ((dataUrl.length * 3) / 4 / 1024);
                            quality -= 0.05;
                        } while ((sizeKB > maxSizeKB || sizeKB < 50) && quality > 0.1);

                        fetch(dataUrl)
                            .then((res) => res.blob())
                            .then((blob) => callback(blob, width, height))
                            .catch(() => callback(file, img.width, img.height));
                    };
                    img.onerror = () => callback(file, 0, 0);
                    img.src = e.target.result;
                };
                reader.onerror = () => callback(file, 0, 0);
                reader.readAsDataURL(file);
            }

            // File preview
            function previewFile(inputId, previewId, infoId) {
                const input = document.getElementById(inputId);
                const preview = document.getElementById(previewId);
                const info = document.getElementById(infoId);
                const sizeSpan = document.getElementById(`${inputId}_size`);
                const resolutionSpan = document.getElementById(`${inputId}_resolution`);
                const typeSpan = document.getElementById(`${inputId}_type`);

                const resetUI = (message = '') => {
                    preview.src = '#';
                    preview.classList.add('hidden');
                    info.classList.add('hidden');
                    sizeSpan.textContent = '';
                    resolutionSpan.textContent = '';
                    typeSpan.textContent = '';
                    input.setCustomValidity(message);
                    if (message) {
                        alert(message);
                    }
                };

                if (!input.files || !input.files[0]) {
                    resetUI();
                    return;
                }

                const file = input.files[0];
                const maxSize = 524288; // 512 KB
                const fileType = file.type;
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];

                if (!allowedTypes.includes(fileType)) {
                    input.value = '';
                    resetUI('Invalid file type. Please upload JPG, PNG, GIF, or PDF.');
                    return;
                }

                if (file.size > maxSize) {
                    input.value = '';
                    resetUI('File size exceeds 512KB. Please choose a smaller file.');
                    return;
                }

                if (fileType.startsWith('image/')) {
                    resizeImage(file, 1024, 1024, 512, (resizedBlob, width, height) => {
                        const url = URL.createObjectURL(resizedBlob);
                        preview.src = url;
                        preview.classList.remove('hidden');
                        info.classList.remove('hidden');

                        sizeSpan.textContent = (resizedBlob.size / 1024).toFixed(2);
                        resolutionSpan.textContent = `${width}x${height}`;
                        typeSpan.textContent = resizedBlob.type.split('/')[1].toUpperCase();

                        const newFile = new File([resizedBlob], file.name, {
                            type: resizedBlob.type
                        });
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(newFile);
                        input.files = dataTransfer.files;
                        input.setCustomValidity('');
                    });
                } else {
                    preview.src = '#';
                    preview.classList.add('hidden');
                    info.classList.remove('hidden');
                    sizeSpan.textContent = (file.size / 1024).toFixed(2);
                    resolutionSpan.textContent = 'N/A (PDF)';
                    typeSpan.textContent = 'PDF';
                    input.setCustomValidity('');
                }
            }

            // Initialize existing file previews
            function initializeFilePreviews() {
                const fileInputs = [
                    'avatar_url',
                    'nid_front_attachment',
                    'nid_back_attachment',
                    'driving_license_front_attachment',
                    'driving_license_back_attachment',
                    'insurance_attachment',
                ];

                fileInputs.forEach((id) => {
                    const input = document.getElementById(id);
                    const preview = document.getElementById(`${id}_preview`);
                    const info = document.getElementById(`${id}_info`);

                    if (input && preview && info) {
                        // If there's an existing file, ensure preview is visible
                        if (preview.src && !preview.classList.contains('hidden')) {
                            info.classList.remove('hidden');
                        }

                        input.addEventListener('change', () => {
                            previewFile(id, `${id}_preview`, `${id}_info`);
                        });
                    }
                });
            }

            initializeFilePreviews();
        });
    </script>
@endpush
