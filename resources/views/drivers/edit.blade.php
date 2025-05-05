@extends('layouts.app')

@section('title', 'Edit Employee')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css" as="style">
    <link rel="stylesheet" href="{{ asset('assets/css/employees/employee-create.min.css') }}" as="style">
@endpush

@section('content')
    <div class="form-container">
        <div class="card">
            <h1 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Edit Employee: {{ $employee->employee_name }}</h1>

            @if ($errors->any())
                <div class="error-message">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="employeeForm" method="POST" action="{{ route('employees.update', $employee->employee_id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="member_activation_id" value="{{ $member->member_activation_id ?? \Illuminate\Support\Str::uuid() }}">
                <input type="hidden" name="pass_changed" value="0">

                <div class="form-grid">
                    <!-- Column 1: Employment & Personal Information -->
                    <div>
                        <!-- Employment Information -->
                        <div>
                            <h2 class="section-title">Employment Information</h2>
                            
                            <x-form.input-group name="transport_id" label="Transport Name" type="select" required
                                :options="$transports->map(fn($t) => ['value' => $t->transport_id, 'label' => $t->transport_name ?? 'Transport ' . $t->transport_id, 'selected' => old('transport_id', $employee->transport_id) == $t->transport_id])->prepend(['value' => '', 'label' => 'Select Transport'])"
                                hint="Select provider" />
                            <x-form.input-group name="department_id" label="Department" type="select" required
                                :options="$departments->map(fn($d) => ['value' => $d->department_id, 'label' => $d->department_name ?? 'Department ' . $d->department_id, 'selected' => old('department_id', $employee->department_id) == $d->department_id])->prepend(['value' => '', 'label' => 'Select Department'])"
                                hint="Choose department" />
                            <x-form.input-group name="work_group_id" label="Work Group" type="select" required
                                :options="$workGroups->map(fn($g) => ['value' => $g->work_group_id, 'label' => $g->work_group_name ?? 'Work Group ' . $g->work_group_id, 'selected' => old('work_group_id', $employee->work_group_id) == $g->work_group_id])->prepend(['value' => '', 'label' => 'Select Work Group'])"
                                hint="Select group" />
                        </div>

                        <!-- Personal Information -->
                        <div class="mt-2">
                            <h2 class="section-title">Personal Information</h2>
                            <x-form.input-group name="employee_name" label="Employee Name" type="text" required
                                minlength="4" maxlength="100" pattern="^[A-Za-z. ]+$"
                                title="4–100 characters, letters, spaces, periods" hint="e.g., John Doe"
                                :value="old('employee_name', $employee->employee_name)" />
                            <x-form.input-group name="employee_phone" label="Phone Number" type="tel" required
                                pattern="^0[0-9]{9,10}$" maxlength="11" placeholder="01789012345"
                                title="10-11 digits starting with 0" hint="e.g., 01789012345"
                                :value="old('employee_phone', $employee->employee_phone)" />
                            <x-form.input-group name="member_email" label="Email Address" type="email" maxlength="255"
                                hint="e.g., user@example.com, optional" :value="old('member_email', $member->member_email)" />
                        </div>
                    </div>

                    <!-- Column 2: Additional Personal & More Employment Info -->
                    <div>
                        <!-- Additional Personal Information -->
                        <div>
                            <h2 class="section-title">Additional Personal Info</h2>
                            <x-form.input-group name="employee_identity" label="Employee ID" type="text"
                                minlength="4" maxlength="10" pattern="^[A-Z0-9]+$" title="4–10 uppercase letters and numbers"
                                hint="e.g., EMP1234, optional" :value="old('employee_identity', $employee->employee_identity)" />
                            <x-form.input-group name="employee_birth_date" id="employee_birth_date" label="Date of Birth"
                                type="text" required placeholder="YYYY-MM-DD" hint="15+ years old"
                                :value="old('employee_birth_date', $employee->employee_birth_date?->format('Y-m-d'))"
                                extra-attributes="data-flatpickr='{\"dateFormat\": \"Y-m-d\", \"maxDate\": \"{{ now()->subYears(15)->format('Y-m-d') }}\", \"minDate\": \"{{ now()->subYears(100)->format('Y-m-d') }}\"}'" />
                            <x-form.file-input name="avatar_url" id="avatar_url" label="Photo" accept="image/jpeg,image/png,image/webp"
                                hint="JPG/PNG/WebP, max 1MB, optional" />
                            <div class="mt-2">
                                <img id="imagePreview" src="{{ $employee->avatar_url ? asset('storage/' . $employee->avatar_url) : '#' }}"
                                    alt="Photo Preview" class="{{ $employee->avatar_url ? '' : 'hidden' }} max-w-[100px] max-h-[100px] rounded border" />
                                <button type="button" id="removeImage" class="{{ $employee->avatar_url ? '' : 'hidden' }} mt-2 text-sm text-red-600 hover:text-red-800" onclick="Utils.clearImage()">Remove Photo</button>
                            </div>
                        </div>

                        <!-- More Employment Information -->
                        <div class="mt-2">
    <h2 class="section-title">More Employment Info</h2>
    <x-form.input-group 
        name="employee_joining_date" 
        id="employee_joining_date" 
        label="Joining Date"
        type="text" 
        required 
        placeholder="YYYY-MM-DD"
        hint="At least 15 years after birth date. Future dates allowed."
        :value="old('employee_joining_date', $employee->employee_joining_date?->format('Y-m-d'))"
        extra-attributes="@json(['dateFormat' => 'Y-m-d'])">
        <p id="date-error" class="error-text hidden opacity-0 transition-opacity duration-300">
            Joining date must be at least 15 years after birth date.
        </p>
    </x-form.input-group>

    <x-form.input-group 
        name="employee_reference" 
        label="References" 
        type="text"
        minlength="3" 
        maxlength="100" 
        hint="e.g., Jane Smith, optional"
        :value="old('employee_reference', $employee->employee_reference)" />

    <x-form.input-group 
        name="employee_pre_experience" 
        label="Experience (Years)" 
        type="number"
        min="0" 
        max="75" 
        step="1" 
        hint="0–75 years, optional"
        :value="old('employee_pre_experience', $employee->employee_pre_experience ?? 0)" />
</div>

                    </div>

                    <!-- Column 3: Account Information & Addresses -->
                    <div>
                        <!-- Account Information -->
                        <div>
                            <h2 class="section-title">Account Information</h2>
                            <x-form.input-group name="member_login" label="Login Name" type="text" required
                                minlength="4" maxlength="20" pattern="^[a-zA-Z0-9]+$" title="4–20 characters, letters and numbers"
                                hint="e.g., user123" :value="old('member_login', $member->member_login)" />
                            <x-form.password-input name="member_new_password" id="member_new_password" label="Password"
                                minlength="6" maxlength="20" placeholder="Enter new password"
                                hint="6–20 characters, optional" :value="old('member_new_password')"
                                extra-attributes="autocomplete='new-password' data-toggle-password='member_new_password'" />
                            <x-form.password-input name="member_new_password_confirmation" id="member_new_password_confirmation" label="Confirm Password"
                                minlength="6" maxlength="20" placeholder="Repeat password"
                                hint="Must match password, optional" extra-attributes="autocomplete='new-password' data-toggle-password='member_new_password_confirmation'" />
                        </div>

                        <!-- Addresses -->
                        <div class="mt-2">
                            <h2 class="section-title">Addresses</h2>
                            <x-form.input-group name="employee_present_address" id="employee_present_address" label="Present Address" type="textarea"
                                required maxlength="255" rows="2"
                                hint="Max 255 characters (<span id='present_address_counter' class='character-counter' data-max='255'>0</span>/255)"
                                :value="old('employee_present_address', $employee->employee_present_address)"
                                extra-attributes="data-char-count='present_address_counter'" />
                            <x-form.input-group name="employee_permanent_address" id="employee_permanent_address" label="Permanent Address" type="textarea"
                                required maxlength="255" rows="2"
                                hint="Max 255 characters (<span id='permanent_address_counter' class='character-counter' data-max='255'>0</span>/255)"
                                :value="old('employee_permanent_address', $employee->employee_permanent_address)"
                                extra-attributes="data-char-count='permanent_address_counter'" />
                        </div>
                    </div>

                    <!-- Column 4: Permissions -->
                    <div class="permissions-column">
                        <h2 class="section-title">Permissions</h2>
                        <x-form.checkbox-group name="employee_save_status" label="Activate Account" value="1"
                            :checked="old('employee_save_status', $employee->employee_save_status) == '1'" hint="Enable account" />
                        <x-form.checkbox-group name="can_cancel_sold" label="Cancel Sold Tickets" value="1"
                            :checked="old('can_cancel_sold', $employee->can_cancel_sold) == '1'" hint="Allow cancellation" />
                        <x-form.checkbox-group name="can_book" label="Book Tickets" value="1"
                            :checked="old('can_book', $employee->can_book) == '1'" hint="Allow booking" />
                        <x-form.input-group name="max_discount" label="Max Discount" type="number" min="0"
                            hint="e.g., 100, optional" :value="old('max_discount', $employee->max_discount ?? 0)" />
                        <x-form.checkbox-group name="can_sell_complimentary" label="Sell Complimentary" value="1"
                            :checked="old('can_sell_complimentary', $employee->can_sell_complimentary) == '1'" hint="Allow complimentary" />
                        <x-form.checkbox-group name="can_gave_discount" label="Give Discount" value="1"
                            :checked="old('can_gave_discount', $employee->can_gave_discount) == '1'" hint="Allow discounts" />
                        <x-form.checkbox-group name="can_cancel_web_ticket" label="Cancel Web Tickets" value="1"
                            :checked="old('can_cancel_web_ticket', $employee->can_cancel_web_ticket) == '1'" hint="Allow web cancellation" />
                        <x-form.checkbox-group name="expense_entry" label="Expense Entry" value="1"
                            :checked="old('expense_entry', $employee->expense_entry) == '1'" hint="Allow expenses" />
                        <x-form.checkbox-group name="online_booking" label="Online Booking" value="1"
                            :checked="old('online_booking', $employee->online_booking) == '1'" hint="Allow online" />
                        <x-form.checkbox-group name="passenger_list" label="Passenger List" value="1"
                            :checked="old('passenger_list', $employee->passenger_list) == '1'" hint="Access lists" />
                        <x-form.input-group name="nid_no" label="NID No." type="text" minlength="8" maxlength="20"
                            pattern="^[0-9]+$" title="8–20 digits" hint="e.g., 1234567890, optional"
                            :value="old('nid_no', $employee->nid_no)" />
                        <x-form.input-group name="birth_no" label="Birth Reg. No." type="text" minlength="8" maxlength="20"
                            pattern="^[0-9]+$" title="8–20 digits" hint="e.g., 9876543210, optional"
                            :value="old('birth_no', $employee->birth_no)" />
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-6">
                    <button type="button" class="btn btn-outline-secondary px-4 py-2" onclick="window.location='{{ route('employees.index') }}'">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 py-2 flex items-center gap-2" id="submitButton">
                        <svg id="submitSpinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 01-16 0z"></path>
                        </svg>
                        <span id="submitText">Update Employee</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Utils = {
            debounce: (func, wait) => {
                let timeout;
                return (...args) => {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            },
            updateCharCount: (textarea, counterId) => {
                const counter = document.getElementById(counterId);
                if (!textarea || !counter) return;
                const maxLength = parseInt(textarea.getAttribute('maxlength') || 255, 10);
                const currentLength = textarea.value?.length || 0;
                counter.textContent = currentLength;
                counter.classList.toggle('text-yellow-600', currentLength >= maxLength * 0.9 && currentLength < maxLength);
                counter.classList.toggle('text-red-600', currentLength >= maxLength);
            },
            previewImage: () => {
                const input = document.getElementById('avatar_url');
                const preview = document.getElementById('imagePreview');
                const removeButton = document.getElementById('removeImage');
                if (input.files && input.files[0]) {
                    if (input.files[0].size > 1048576) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Too Large',
                            text: 'Profile photo must be 1MB or smaller.',
                            toast: true,
                            position: 'top-end',
                            timer: 3000
                        });
                        input.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        removeButton.classList.remove('hidden');
                    };
                    reader.readAsDataURL(input.files[0]);
                } else {
                    Utils.clearImage();
                }
            },
            clearImage: () => {
                const input = document.getElementById('avatar_url');
                const preview = document.getElementById('imagePreview');
                const removeButton = document.getElementById('removeImage');
                if (input) input.value = '';
                if (preview) {
                    preview.src = '{{ $employee->avatar_url ? asset('storage/' . $employee->avatar_url) : '#' }}';
                    preview.classList.toggle('hidden', !'{{ $employee->avatar_url }}');
                }
                if (removeButton) removeButton.classList.toggle('hidden', !'{{ $employee->avatar_url }}');
            },
            togglePassword: (id) => {
                const input = document.getElementById(id);
                const button = document.querySelector(`[data-toggle-password="${id}"]`);
                const icon = button?.querySelector('i');
                if (!input) return;
                input.type = input.type === 'password' ? 'text' : 'password';
                if (icon) {
                    icon.classList.toggle('fa-eye', input.type === 'password');
                    icon.classList.toggle('fa-eye-slash', input.type === 'text');
                }
            },
            getMinJoiningDate: (birthDate) => {
                if (!birthDate) return '{{ now()->subYears(15)->format('Y-m-d') }}';
                const minDate = new Date(birthDate);
                minDate.setFullYear(minDate.getFullYear() + 15);
                return minDate;
            },
            validateJoiningDate: () => {
                const birthDateInput = document.getElementById('employee_birth_date');
                const joiningDateInput = document.getElementById('employee_joining_date');
                const errorText = document.getElementById('date-error');
                if (!birthDateInput?.value || !joiningDateInput?.value || !errorText) return;
                const birthDate = new Date(birthDateInput.value);
                const joiningDate = new Date(joiningDateInput.value);
                const minJoiningDate = Utils.getMinJoiningDate(birthDate);
                const isValid = joiningDate >= minJoiningDate;
                errorText.classList.toggle('hidden', isValid);
                errorText.classList.toggle('opacity-0', isValid);
                errorText.classList.toggle('opacity-100', !isValid);
                joiningDateInput.setCustomValidity(isValid ? '' : 'Joining date must be at least 15 years after birth date.');
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            const birthDatePicker = flatpickr('#employee_birth_date', {
                dateFormat: 'Y-m-d',
                maxDate: '{{ now()->subYears(15)->format('Y-m-d') }}',
                minDate: '{{ now()->subYears(100)->format('Y-m-d') }}',
                onChange: (selectedDates) => {
                    if (selectedDates.length === 0) return;
                    const birthDate = selectedDates[0];
                    const minJoiningDate = Utils.getMinJoiningDate(birthDate);
                    joiningDatePicker.set('minDate', minJoiningDate);
                    const currentJoiningDate = joiningDatePicker.selectedDates[0];
                    if (!currentJoiningDate || currentJoiningDate < minJoiningDate) {
                        joiningDatePicker.setDate(minJoiningDate, true);
                    }
                    Utils.validateJoiningDate();
                }
            });

            const joiningDatePicker = flatpickr('#employee_joining_date', {
                dateFormat: 'Y-m-d',
                minDate: birthDatePicker.selectedDates[0]
                    ? Utils.getMinJoiningDate(birthDatePicker.selectedDates[0])
                    : '{{ now()->subYears(15)->format('Y-m-d') }}',
                defaultDate: '{{ old('employee_joining_date', $employee->employee_joining_date?->format('Y-m-d')) }}',
                onChange: () => Utils.validateJoiningDate()
            });

            document.querySelectorAll('textarea[data-char-count]').forEach(textarea => {
                const counterId = textarea.dataset.charCount;
                Utils.updateCharCount(textarea, counterId);
                textarea.addEventListener('input', Utils.debounce(() => Utils.updateCharCount(textarea, counterId), 200));
            });

            const form = document.getElementById('employeeForm');
            const submitButton = document.getElementById('submitButton');
            const submitSpinner = document.getElementById('submitSpinner');
            const submitText = document.getElementById('submitText');
            if (form && submitButton && submitSpinner && submitText) {
                form.addEventListener('submit', () => {
                    submitButton.disabled = true;
                    submitSpinner.classList.remove('hidden');
                    submitText.textContent = 'Updating...';
                });
            }

            ['employee_birth_date', 'employee_joining_date'].forEach(id => {
                const input = document.getElementById(id);
                if (input) input.addEventListener('change', Utils.validateJoiningDate);
            });

            ['member_new_password', 'member_new_password_confirmation'].forEach(id => {
                const button = document.querySelector(`[data-toggle-password="${id}"]`);
                if (button) button.addEventListener('click', () => Utils.togglePassword(id));
            });

            const avatarInput = document.getElementById('avatar_url');
            if (avatarInput) avatarInput.addEventListener('change', Utils.previewImage);

            const removeImageButton = document.getElementById('removeImage');
            if (removeImageButton) removeImageButton.addEventListener('click', Utils.clearImage);
        });
    </script>
@endpush