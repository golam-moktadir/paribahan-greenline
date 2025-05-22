@extends('layouts.app')

@section('title', 'Edit Guide - ' . ($guide->full_name ?? 'N/A'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datapicker/flatpickr.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/css/components/create-edit-page.css') }}" as="style">
@endpush

@section('content')
    <div class="container mx-auto">
        <div class="max-w-8xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 sm:p-8">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Edit Guide</h1>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('guides.update', $guide->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Column 1: Employment & Personal Information -->
                    <div class="space-y-6">
                        <!-- Employment Information -->
                        <div>
                            <h2
                                class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">
                                Employment Information
                            </h2>
                            <x-form.input-group name="" label="Transport Name" type="select" disabled
                                :options="$transports
                                    ->map(
                                        fn($t) => [
                                            'value' => $t->transport_id,
                                            'label' => $t->transport_name ?? 'Transport ' . $t->transport_id,
                                            'selected' =>
                                                ($guide->transport_id ?? old('transport_id', 37)) == $t->transport_id,
                                        ],
                                    )
                                    ->prepend(['value' => '', 'label' => 'Select Transport'])" hint="Transport provider" />
                            <input type="hidden" name="transport_id"
                                value="{{ $guide->transport_id ?? old('transport_id', 37) }}" />

                            <x-form.input-group name="department_id" label="Department" type="select" required
                                :options="$departments
                                    ->map(
                                        fn($d) => [
                                            'value' => $d->department_id,
                                            'label' => $d->department_name ?? 'Department ' . $d->department_id,
                                            'selected' =>
                                                ($guide->department_id ?? old('department_id')) == $d->department_id,
                                        ],
                                    )
                                    ->prepend(['value' => '', 'label' => 'Select Department'])" hint="Choose department" />

                            <x-form.input-group name="status" label="Status" type="select" required :options="collect(\App\Models\Guide::STATUSES)->map(
                                fn($label, $value) => [
                                    'value' => $value,
                                    'label' => $label,
                                    'selected' => ($guide->status ?? old('status', 'active')) === $value,
                                ],
                            )"
                                hint="Select status" />

                            <x-form.input-group name="id_no" label="ID No." type="text" minlength="4" maxlength="20"
                                pattern="^[A-Z0-9]+$" title="4–20 uppercase letters and numbers" hint="e.g., DI1234"
                                :value="$guide->id_no ?? old('id_no')" />
                        </div>

                        <!-- Personal Information -->
                        <div>
                            <h2
                                class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">
                                Personal Information
                            </h2>
                            <x-form.input-group name="full_name" label="Full Name" type="text" required minlength="4"
                                maxlength="255" pattern="^[A-Za-z. ]+$" title="4–255 characters, letters, spaces, periods"
                                hint="e.g., John Doe" :value="$guide->full_name ?? old('full_name')" />

                            <x-form.input-group name="father_name" label="Father's Name" type="text" required
                                minlength="4" maxlength="255" pattern="^[A-Za-z. ]+$"
                                title="4–255 characters, letters, spaces, periods" hint="e.g., Michael Smith"
                                :value="$guide->father_name ?? old('father_name')" />

                            <x-form.input-group name="phone" label="Phone Number" type="tel" required
                                pattern="0[0-9]{9,10}" maxlength="11" placeholder="01789012345"
                                title="10-11 digits starting with 0" hint="e.g., 01789012345" :value="$guide->phone ?? old('phone')" />

                            <x-form.input-group name="birth_date" id="birth_date" label="Date of Birth" type="date"
                                required max="{{ \Carbon\Carbon::now()->subYears(15)->format('Y-m-d') }}"
                                extra-attributes="onchange=validateJoiningDate()" hint="15+ years old" :value="$guide->birth_date?->format('Y-m-d') ?? old('birth_date')" />
                        </div>
                    </div>

                    <!-- Column 2: Identification & Attachments -->
                    <div class="space-y-6">
                        <!-- Identification -->
                        <div>
                            <h2
                                class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">
                                Identification
                            </h2>
                            <x-form.input-group name="nid_no" label="NID No." type="text" minlength="8" maxlength="20"
                                required pattern="[0-9]+" title="8–20 digits" hint="e.g., 1234567890" :value="$guide->nid_no ?? old('nid_no')" />

                            <x-form.input-group name="insurance_no" label="Insurance No." type="text" minlength="8"
                                maxlength="30" pattern="[A-Z0-9]+" title="8–30 alphanumeric characters"
                                hint="e.g., INS123456" :value="$guide->insurance_no ?? old('insurance_no')" />
                        </div>

                        <!-- Attachments -->
                        <div>
                            <h2
                                class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">
                                Attachments
                            </h2>
                            <!-- Profile Photo -->
                            <div>
                                <x-form.file-input name="avatar_url" label="Profile Photo" accept=".jpg,.jpeg,.png,.gif"
                                    hint="JPG/PNG/GIF, max 512KB" />
                                <div class="mt-2">
                                    @if ($guide->avatar_url)
                                        <img id="avatar_url_preview" src="{{ asset($guide->avatar_url) }}"
                                            class="w-32 h-auto rounded-lg border border-gray-200 dark:border-gray-600"
                                            alt="Profile Photo Preview">
                                    @else
                                        <img id="avatar_url_preview"
                                            class="hidden w-32 h-auto rounded-lg border border-gray-200 dark:border-gray-600"
                                            alt="Profile Photo Preview">
                                    @endif
                                    <div id="avatar_url_info"
                                        class="text-sm text-gray-600 dark:text-gray-300 mt-2 {{ $guide->avatar_url ? '' : 'hidden' }}">
                                        <p><strong>File Size:</strong> <span id="avatar_url_size"></span> KB</p>
                                        <p><strong>Resolution:</strong> <span id="avatar_url_resolution"></span></p>
                                        <p><strong>File Type:</strong> <span id="avatar_url_type"></span></p>
                                    </div>
                                </div>
                            </div>
                            <!-- NID Scan -->
                            <div class="mt-4">
                                <x-form.file-input name="nid_attachment" label="NID Scan"
                                    accept=".jpg,.jpeg,.png,.gif,.pdf" required hint="JPG/PNG/GIF/PDF, max 512KB" />
                                <div class="mt-2">
                                    @if ($guide->nid_attachment)
                                        <img id="nid_attachment_preview" src="{{ asset($guide->nid_attachment) }}"
                                            class="w-32 h-auto rounded-lg border border-gray-200 dark:border-gray-600"
                                            alt="NID Scan Preview">
                                    @else
                                        <img id="nid_attachment_preview"
                                            class="hidden w-32 h-auto rounded-lg border border-gray-200 dark:border-gray-600"
                                            alt="NID Scan Preview">
                                    @endif
                                    <div id="nid_attachment_info"
                                        class="text-sm text-gray-600 dark:text-gray-300 mt-2 {{ $guide->nid_attachment ? '' : 'hidden' }}">
                                        <p><strong>File Size:</strong> <span id="nid_attachment_size"></span> KB</p>
                                        <p><strong>Resolution:</strong> <span id="nid_attachment_resolution"></span></p>
                                        <p><strong>File Type:</strong> <span id="nid_attachment_type"></span></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Insurance Document -->
                            <div class="mt-4">
                                <x-form.file-input name="insurance_attachment" label="Insurance Document"
                                    accept=".jpg,.jpeg,.png,.gif,.pdf" hint="JPG/PNG/GIF/PDF, conhece max 512KB" />
                                <div class="mt-2">
                                    @if ($guide->insurance_attachment)
                                        <img id="insurance_attachment_preview"
                                            src="{{ asset($guide->insurance_attachment) }}"
                                            class="w-32 h-auto rounded-lg border border-gray-200 dark:border-gray-600"
                                            alt="Insurance Document Preview">
                                    @else
                                        <img id="insurance_attachment_preview"
                                            class="hidden w-32 h-auto rounded-lg border border-gray-200 dark:border-gray-600"
                                            alt="Insurance Document Preview">
                                    @endif
                                    <div id="insurance_attachment_info"
                                        class="text-sm text-gray-600 dark:text-gray-300 mt-2 {{ $guide->insurance_attachment ? '' : 'hidden' }}">
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
                    <div class="space-y-6">
                        <!-- Work Information -->
                        <div>
                            <h2
                                class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">
                                Work Information
                            </h2>
                            <x-form.input-group name="pre_experience" label="Previous Experience (Years)" type="number"
                                min="0" max="75" step="1" required hint="0–75 years"
                                :value="$guide->pre_experience ?? old('pre_experience', 0)" />

                            <x-form.input-group name="joining_date" id="joining_date" label="Joining Date"
                                type="date" required extra-attributes="onchange=validateJoiningDate()"
                                hint="Must be at least 15 years after birth date" :value="$guide->joining_date?->format('Y-m-d') ?? old('joining_date')" />
                            <p id="date-error" class="text-red-600 text-sm mt-1 hidden">
                                Joining date must be at least 15 years after the birth date.
                            </p>

                            <x-form.input-group name="reference" label="Reference" type="text" minlength="4"
                                maxlength="100" required hint="e.g., Jane Smith" :value="$guide->reference ?? old('reference')" />
                        </div>

                        <!-- Addresses -->
                        <div>
                            <h2
                                class="text-lg font-semibold text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-600 pb-2 mb-4">
                                Addresses
                            </h2>
                            <x-form.input-group name="present_address" label="Present Address" type="textarea" required
                                maxlength="255" rows="2" id="present_address"
                                extra-attributes="oninput=updateCharCount('present_address', 'present_address_counter')"
                                hint="Max 255 characters" :value="$guide->present_address ?? old('present_address')" />
                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                <span
                                    id="present_address_counter">{{ strlen($guide->present_address ?? old('present_address', '')) }}</span>/255
                            </div>
                            <x-form.input-group name="permanent_address" label="Permanent Address" type="textarea"
                                required maxlength="255" rows="2" id="permanent_address"
                                extra-attributes="oninput=updateCharCount('permanent_address', 'permanent_address_counter')"
                                hint="Max 255 characters" :value="$guide->permanent_address ?? old('permanent_address')" />
                            <div class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                <span
                                    id="permanent_address_counter">{{ strlen($guide->permanent_address ?? old('permanent_address', '')) }}</span>/255
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('guides.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-save mr-2"></i> Update Guide
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/datapicker/flatpickr.min.js') }}"></script>
    <script>
        function initializeFlatpickr() {
            let joiningDatePicker;

            // Birth date picker
            const birthDatePicker = flatpickr('#birth_date', {
                dateFormat: 'Y-m-d',
                maxDate: '{{ \Carbon\Carbon::now()->subYears(15)->format('Y-m-d') }}',
                minDate: '{{ \Carbon\Carbon::now()->subYears(100)->format('Y-m-d') }}',
                onChange: function(selectedDates) {
                    if (selectedDates.length > 0) {
                        const birthDate = new Date(selectedDates[0]);
                        const minJoiningDate = new Date(birthDate.setFullYear(birthDate.getFullYear() + 15));

                        joiningDatePicker.set('minDate', minJoiningDate);
                        joiningDatePicker.set('maxDate', null);

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
                callback(file, 0, 0);
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    let width = img.width;
                    let height = img.height;

                    if (width <= maxWidth && height <= maxHeight && file.size <= maxSizeKB * 1024) {
                        callback(file, width, height);
                        return;
                    }

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

                    let quality = 0.9;
                    let dataUrl;
                    do {
                        dataUrl = canvas.toDataURL('image/jpeg', quality);
                        const sizeKB = ((dataUrl.length * 3) / 4 / 1024).toFixed(2);
                        if (sizeKB <= maxSizeKB) break;
                        quality -= 0.1;
                    } while (quality > 0.1);

                    fetch(dataUrl)
                        .then(res => res.blob())
                        .then(blob => callback(blob, width, height))
                        .catch(() => callback(file, img.width, img.height));
                };
                img.onerror = () => callback(file, 0, 0);
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

            if (!input.files || !input.files[0]) {
                input.setCustomValidity('');
                return;
            }

            const file = input.files[0];
            const maxSize = 524288; // 512 KB
            const fileType = file.type;
            const isImage = fileType.startsWith('image/');
            const isPDF = fileType === 'application/pdf';
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];

            if (!allowedTypes.includes(fileType)) {
                alert('Invalid file type. Please upload JPG, PNG, GIF, or PDF.');
                input.value = '';
                input.setCustomValidity('Invalid file type.');
                preview.src = '#';
                info.classList.add('hidden');
                return;
            }

            if (file.size > maxSize) {
                alert('File size exceeds 512KB. Please choose a smaller file.');
                input.value = '';
                input.setCustomValidity('File size exceeds 512KB.');
                preview.src = '#';
                info.classList.add('hidden');
                return;
            }

            if (isImage) {
                resizeImage(file, 1024, 1024, 512, (resizedBlob, width, height) => {
                    const url = URL.createObjectURL(resizedBlob);
                    preview.src = url;
                    preview.classList.remove('hidden');
                    info.classList.remove('hidden');

                    const sizeKB = (resizedBlob.size / 1024).toFixed(2);
                    sizeSpan.textContent = sizeKB;
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
            initializeFlatpickr();

            ['present_address', 'permanent_address'].forEach(id => {
                const textarea = document.getElementById(id);
                if (textarea) {
                    updateCharCount(id, `${id}_counter`);
                    textarea.addEventListener('input', () => updateCharCount(id, `${id}_counter`));
                }
            });

            ['avatar_url', 'nid_attachment', 'driving_license_attachment', 'insurance_attachment'].forEach(id =>
                document.getElementById(id)?.addEventListener('change', () => previewFile(id, `${id}_preview`,
                    `${id}_info`))
            );
        });
    </script>
@endpush
