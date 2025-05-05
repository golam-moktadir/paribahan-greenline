@extends('layouts.app')

@section('title', 'Add Employee')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datapicker/flatpickr.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/css/employees/employee-create.min.css') }}" as="style">
@endpush

@section('content')
    <div class="form-container">
        <div class="card">
            <h1 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Add New Employee</h1>

            @if ($errors->any())
                <div class="error-message">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="employee_saved_by" value="1">
                <input type="hidden" name="employee_activation_id" value="{{ \Illuminate\Support\Str::uuid() }}">

                <div class="form-grid">
                    <!-- Column 1: Employment & Personal Information -->
                    <div>
                        <!-- Employment Information -->
                        <div>
                            <h2 class="section-title">Employment Information</h2>
                            <x-form.input-group name="" label="Member Type" type="select" disabled :options="$memberTypes
                                ->map(
                                    fn($t) => [
                                        'value' => $t->member_type_id,
                                        'label' => $t->member_type_name ?? 'Member Type ' . $t->member_type_id,
                                        'selected' => old('member_type_id', 2) == $t->member_type_id,
                                    ],
                                )
                                ->prepend(['value' => '', 'label' => 'Select Member Type'])"
                                hint="Select member type" />

                            <!-- Hidden input  -->
                            <input type="hidden" name="member_type_id" value="{{ old('member_type_id', 2) }}" />

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
                            <x-form.input-group name="work_group_id" label="Work Group" type="select" required
                                :options="$workGroups
                                    ->map(
                                        fn($g) => [
                                            'value' => $g->work_group_id,
                                            'label' => $g->work_group_name ?? 'Work Group ' . $g->work_group_id,
                                            'selected' => old('work_group_id') == $g->work_group_id,
                                        ],
                                    )
                                    ->prepend(['value' => '', 'label' => 'Select Work Group'])" hint="Select group" />
                        </div>

                        <!-- Personal Information -->
                        <div class="mt-2">
                            <h2 class="section-title">Personal Information</h2>
                            <x-form.input-group name="employee_name" label="Employee Name" type="text" required
                                minlength="4" maxlength="100" pattern="^[A-Za-z. ]+$"
                                title="4–100 characters, letters, spaces, periods" hint="e.g., John Doe"
                                :value="old('employee_name')" />
                            <x-form.input-group name="employee_phone" label="Phone Number" type="tel" required
                                pattern="0[0-9]{9,10}" maxlength="11" placeholder="01789012345"
                                title="10-11 digits starting with 0" hint="e.g., 01789012345" :value="old('employee_phone')" />
                            <x-form.input-group name="member_email" label="Email Address" type="email" maxlength="255"
                                hint="e.g., user@example.com" :value="old('member_email')" />
                        </div>

                        <!-- Account Information -->
                        <div>
                            <h2 class="section-title">Account Information</h2>
                            <x-form.input-group name="member_login" label="Login Name" type="text" required
                                minlength="4" maxlength="20" pattern="^[a-zA-Z0-9]+$"
                                title="4–20 characters, letters and numbers" hint="e.g., user123" :value="old('member_login')" />
                            <x-form.password-input name="member_new_password" label="Password" required minlength="6"
                                maxlength="20" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{6,20}$"
                                title="6–20 characters, include uppercase, lowercase, number, symbol" hint="e.g., Pass123!"
                                :value="old('member_new_password')" />
                            <x-form.password-input name="member_new_password_confirmation" label="Confirm Password" required
                                minlength="6" maxlength="20" title="Must match password" hint="Repeat password" />
                        </div>
                    </div>

                    <!-- Column 2: Additional Personal & More Employment Info -->
                    <div>
                        <!-- Additional Personal Information -->
                        <div>
                            <h2 class="section-title">Additional Personal Info</h2>
                            <x-form.input-group name="employee_identity" label="Employee ID" type="text" minlength="4"
                                maxlength="10" pattern="^[A-Z0-9]+$" title="4–10 uppercase letters and numbers"
                                hint="e.g., EMP1234" :value="old('employee_identity')" />
                            <x-form.input-group name="employee_birth_date" id="employee_birth_date" label="Date of Birth"
                                type="date" required max="{{ \Carbon\Carbon::now()->subYears(15)->format('Y-m-d') }}"
                                extra-attributes="onchange=validateJoiningDate()" hint="15+ years old"
                                :value="old('employee_birth_date')" />
                            <x-form.file-input name="avatar_url" label="Photo" accept=".jpg,.jpeg,.png,.webp"
                                hint="JPG/PNG, max 1MB" />
                            <x-form.input-group name="nid_no" label="NID No." type="text" minlength="8"
                                maxlength="20" pattern="[0-9]+" title="8–20 digits" hint="e.g., 1234567890"
                                :value="old('nid_no')" />
                            <x-form.input-group name="birth_no" label="Birth Reg. No." type="text" minlength="8"
                                maxlength="20" pattern="[0-9]+" title="8–20 digits" hint="e.g., 9876543210"
                                :value="old('birth_no')" />
                        </div>

                        <!-- More Employment Information -->
                        <div class="mt-2">
                            <h2 class="section-title">More Employment Info</h2>
                            <x-form.input-group name="employee_joining_date" id="employee_joining_date"
                                label="Joining Date" type="date" required
                                extra-attributes="onchange=validateJoiningDate()"
                                hint="Must be at least 15 years after birth date. Future dates are allowed."
                                :value="old('employee_joining_date')">

                                <p id="date-error" class="error-text hidden">
                                    Joining date must be at least 15 years after the birth date. Future dates are allowed.
                                </p>
                            </x-form.input-group>
                            <x-form.input-group name="employee_reference" label="References" type="text" required
                                minlength="3" maxlength="100" hint="e.g., Jane Smith" :value="old('employee_reference')" />
                            <x-form.input-group name="employee_pre_experience" label="Experience (Years)" type="number"
                                min="0" max="75" step="1" hint="0–75 years" :value="old('employee_pre_experience', 0)" />
                        </div>

                        <!-- Account Information & Addresses -->

                        <!-- Addresses -->
                        <div class="mt-2">
                            <h2 class="section-title">Addresses</h2>
                            <x-form.input-group name="employee_present_address" label="Present Address" type="textarea"
                                required maxlength="255" rows="2"
                                extra-attributes="oninput=updateCharCount('employee_present_address', 'present_address_counter')"
                                hint="<span id='present_address_counter'>0</span>/255" :value="old('employee_present_address')" />
                            <x-form.input-group name="employee_permanent_address" label="Permanent Address"
                                type="textarea" required maxlength="255" rows="2"
                                extra-attributes="oninput=updateCharCount('employee_permanent_address', 'permanent_address_counter')"
                                hint="<span id='permanent_address_counter'>0</span>/255" :value="old('employee_permanent_address')" />
                        </div>
                    </div>

                    <!-- Column 4: Permissions -->
                    <div class="permissions-column">
                        <h2 class="section-title">Permissions</h2>
                        <x-form.checkbox-group name="employee_save_status" label="Activate this Account" value="1"
                            :checked="old('employee_save_status', '0') == '1'" hint="Enable account" />
                        <x-form.checkbox-group name="can_cancel_sold" label="Can Cancel Sold Tickets" value="1"
                            :checked="old('can_cancel_sold') == '1'" hint="Allow cancellation" />
                        <x-form.checkbox-group name="can_book" label="Can Book Tickets" value="1" :checked="old('can_book') == '1'"
                            hint="Allow booking" />
                        <x-form.checkbox-group name="can_sell_complimentary" label="Can Sell Complimentary Tickets"
                            value="1" :checked="old('can_sell_complimentary') == '1'" hint="Allow complimentary" />
                        <x-form.checkbox-group name="can_gave_discount" label="Can give discount on ticket sale"
                            value="1" :checked="old('can_gave_discount') == '1'" hint="Allowed Discount Amount" />
                        <x-form.checkbox-group name="can_cancel_web_ticket"
                            label="Can Cancecel 'G/' Series or Web tickets" value="1" :checked="old('can_cancel_web_ticket') == '1'"
                            hint="Allow web cancellation" />
                        <x-form.input-group name="max_discount" label="Max Discount" type="number" min="0"
                            hint="e.g., 100" :value="old('max_discount', 0)" />

                        <h3 class="section-sub-title">Set Permissions</h3>
                        <x-form.checkbox-group name="expense_entry" label="Expense Entry Information" value="1"
                            :checked="old('expense_entry', '1') == '1'" hint="Allow expenses" />
                        <x-form.checkbox-group name="online_booking" label="Online Ticket Booking" value="1"
                            :checked="old('online_booking', '1') == '1'" hint="Allow online" />
                        <x-form.checkbox-group name="passenger_list" label="Passenger List Detail" value="1"
                            :checked="old('passenger_list', '1') == '1'" hint="Access lists" />
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
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = "{{ asset('assets/vendor/datapicker/flatpickr.min.css') }}";
            document.head.appendChild(link);

            const script = document.createElement('script');
            script.src = "{{ asset('assets/vendor/datapicker/flatpickr.min.js') }}";
            script.onload = () => {
                let joiningDatePicker;

                // Birth date picker (minimum 15 years ago, maximum 100 years ago)
                const birthDatePicker = flatpickr('#employee_birth_date', {
                    dateFormat: 'Y-m-d',
                    maxDate: '{{ now()->subYears(15)->format('Y-m-d') }}',
                    minDate: '{{ now()->subYears(100)->format('Y-m-d') }}',
                    onChange: function(selectedDates) {
                        // When birth date changes, update joining date minimum
                        if (selectedDates.length > 0) {
                            const birthDate = new Date(selectedDates[0]);
                            const minJoiningDate = new Date(birthDate.setFullYear(birthDate.getFullYear() +
                                15));

                            // Update joining date picker's minDate
                            joiningDatePicker.set('minDate', minJoiningDate);
                            joiningDatePicker.set('maxDate', null);

                            // If current joining date is before the new minDate, clear it
                            if (joiningDatePicker.selectedDates.length > 0 &&
                                joiningDatePicker.selectedDates[0] < minJoiningDate) {
                                joiningDatePicker.clear();
                            }

                            // Update validateJoiningDate on birthdate change
                            validateJoiningDate();

                        }
                    }
                });

                // Initialize joiningDatePicker globally
                joiningDatePicker = flatpickr('#employee_joining_date', {
                    dateFormat: 'Y-m-d',
                    maxDate: '{{ date('Y-m-d') }}',
                    minDate: '{{ now()->subYears(15)->format('Y-m-d') }}',
                    defaultDate: '{{ date('Y-m-d') }}',
                    onChange: validateJoiningDate
                });
            };
            document.body.appendChild(script);
        }

        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
            input.type = input.type === 'password' ? 'text' : 'password';
            icon.classList.toggle('fa-eye', input.type === 'password');
            icon.classList.toggle('fa-eye-slash', input.type === 'text');
        }

        function previewImage() {
            const input = document.getElementById('avatar_url');
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                if (input.files[0].size > 1048576) {
                    alert('File size exceeds 1MB.');
                    input.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '#';
                preview.classList.add('hidden');
            }
        }

        function updateCharCount(id, counterId) {
            const textarea = document.getElementById(id);
            if (textarea) document.getElementById(counterId).textContent = textarea.value.length;
        }

        function validateJoiningDate() {
            const birthDateInput = document.getElementById('employee_birth_date').value;
            const joiningDateInput = document.getElementById('employee_joining_date');
            const errorText = document.getElementById('date-error');

            if (birthDateInput) {
                const birthDate = new Date(birthDateInput);
                const joiningDate = new Date(joiningDateInput.value);
                const minJoiningDate = new Date(birthDate.setFullYear(birthDate.getFullYear() + 15));

                const isValid = joiningDate >= minJoiningDate;
                errorText.classList.toggle('hidden', isValid);
                joiningDateInput.setCustomValidity(isValid ? '' :
                    'Joining date must be at least 15 years after birth date.');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            loadFlatpickr();
            ['employee_present_address', 'employee_permanent_address'].forEach(id =>
                updateCharCount(id, `${id}_counter`)
            );
        });
    </script>
@endpush
