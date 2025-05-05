@extends('layouts.app')

@section('title', 'Employee Details')

@section('content')
    <div class="container mx-auto px-4 py-6 max-w-6xl">
        <!-- Card Container -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <!-- Header with Actions -->
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Employee Details</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('employees.index') }}"
                        class="px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500"
                        aria-label="Back to employee list">Back</a>
                    <a href="{{ route('employees.edit', ['employee' => $employee->employee_id ?? '']) }}"
                        class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 transition text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500"
                        aria-label="Edit employee details">Edit</a>
                </div>
            </div>

            <!-- Fallback for Missing Employee -->
            @unless ($employee)
                <div class="p-6 text-center text-gray-500 dark:text-gray-400">Employee not found.</div>
            @else
                <!-- Main Content Grid -->
                <div
                    class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-200 dark:divide-gray-700">

                    <!-- Employment Information Column -->
                    <section class="p-6" role="region" aria-label="Employment Information">
                        <h2
                            class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                            Employment Info</h2>
                        <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Member Type</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->transport->transport_name ?? 'N/A' }}</span>
                            </div>


                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Transport</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->transport->transport_name ?? 'N/A' }}</span>
                            </div>


                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Department</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->department->department_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Work Group</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->workGroup->work_group_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Joining Date</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->employee_joining_date?->format('Y-m-d') ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">References</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->employee_reference ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Experience</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->employee_pre_experience ?? 0 }}
                                    years</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Signature</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->employee_signature ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </section>


                    <!-- Personal Information Column -->
                    <section class="p-6" role="region" aria-label="Personal Information">
                        <h2
                            class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                            Personal Info</h2>
                        <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Photo</span>
                                @if ($employee->avatar_url && file_exists(public_path($employee->avatar_url)))
                                    <img src="{{ asset($employee->avatar_url) }}" alt="Employee photo"
                                        class="w-12 h-12 rounded-full object-cover border-2 border-blue-600" loading="lazy">
                                @else
                                    <span class="text-gray-400">No photo</span>
                                @endif
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Name</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->employee_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Login</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->employee_login ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Email</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->email ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Phone</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->employee_phone ?? 'N/A' }}</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Birth Date</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->employee_birth_date?->format('Y-m-d') ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">NID No.</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->nid_no ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Birth No.</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->birth_no ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-start">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Present Address</span>
                                <span class="text-xs text-gray-800 dark:text-gray-100 break-words max-w-xs text-right">
                                    {{ $employee->employee_present_address ?? 'N/A' }}
                                </span>
                            </div>

                            <div class="flex justify-between items-start mt-2">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Permanent Address</span>
                                <span class="text-xs text-gray-800 dark:text-gray-100 break-words max-w-xs text-right">
                                    {{ $employee->employee_permanent_address ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </section>



                    <!-- Account Information Column -->
                    <section class="p-6" role="region" aria-label="Account Information">
                        <h2
                            class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-700">
                            Account Info</h2>
                        <div class="space-y-4 text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Status</span>
                                <span
                                    class="text-sm {{ $employee->employee_save_status ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $employee->employee_save_status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Cancel Sold</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->can_cancel_sold ? 'Yes' : 'No' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Book Tickets</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->can_book ? 'Yes' : 'No' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Sell Complimentary</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->can_sell_complimentary ? 'Yes' : 'No' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Give Discount</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->can_gave_discount ? 'Yes' : 'No' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Max Discount</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->max_discount ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Cancel Web Tickets</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->can_cancel_web_ticket ? 'Yes' : 'No' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Expense Entry</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->expense_entry ? 'Yes' : 'No' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Online Booking</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->online_booking ? 'Yes' : 'No' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-600 dark:text-gray-300">Passenger List</span>
                                <span
                                    class="text-gray-800 dark:text-gray-100 overflow-wrap break-word">{{ $employee->passenger_list ? 'Yes' : 'No' }}</span>
                            </div>
                        </div>
                    </section>
                </div>
            @endunless
        </div>
    </div>
@endsection
