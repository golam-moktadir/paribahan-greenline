@extends('layouts.app')

@section('title', 'Archived Employees')

@section('content')
    <div class="container mx-auto px-4 sm:px-5 py-5 max-w-7xl">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-md">
            <!-- Header -->
            <header class="bg-gradient-to-r from-blue-600 to-blue-400 px-5 py-3 flex justify-between items-center">
                <h1 class="text-lg font-bold text-white">Archived Employees</h1>
                <nav class="flex gap-2">
                    <a href="{{ route('employees.index') }}"
                        class="px-2 py-1 bg-white text-blue-600 rounded-md hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 text-xs font-medium transition transform hover:scale-105 focus:outline-none focus:ring-1 focus:ring-blue-500"
                        aria-label="Back to active employees">Active Employees</a>
                </nav>
            </header>

            <!-- Content -->
            <div class="p-5">
                @if (session('success') || $errors->has('error'))
                    <div id="toastNotification"
                        class="fixed top-4 right-4 bg-green-500 text-white p-3 rounded-md text-xs shadow-lg transition-opacity duration-300 {{ $errors->has('error') ? 'bg-red-500' : '' }}"
                        role="alert" aria-live="assertive">
                        @if (session('success'))
                            @php $successData = session('success'); @endphp
                            <strong class="block font-semibold">{{ $successData['title'] }}</strong>
                            <span>{{ $successData['message'] }}</span>
                        @else
                            <strong class="block font-semibold">Error:</strong>
                            <span>{{ $errors->first('error') }}</span>
                        @endif
                    </div>
                @endif

                <!-- Search and Actions -->
                <div class="flex flex-col sm:grid sm:grid-cols-3 gap-3 mb-4">
                    <div class="relative">
                        <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input id="searchName" type="text" placeholder="Search by Name"
                            class="w-full pl-8 pr-3 py-1.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            aria-label="Search by Name">
                    </div>
                    <div class="relative">
                        <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <input id="searchLogin" type="text" placeholder="Search by Login"
                            class="w-full pl-8 pr-3 py-1.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            aria-label="Search by Login">
                    </div>
                    <div class="relative">
                        <svg class="absolute left-2.5 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h12M9 3v2m1.5 0v2M15 3v2m-3 4h12m-3 4h9m-9 4h6m-6 4h3" />
                        </svg>
                        <input id="searchPhone" type="text" placeholder="Search by Phone"
                            class="w-full pl-8 pr-3 py-1.5 border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white rounded-md text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500"
                            aria-label="Search by Phone">
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table id="trashedEmployeesTable" class="min-w-full divide-y divide-gray-200 text-xs" role="grid"
                        aria-label="Archived Employees Table">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th
                                    class="w-12 px-2 py-1 text-left font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">
                                    ID</th>
                                <th
                                    class="w-28 px-2 py-1 text-left font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">
                                    Name</th>
                                <th
                                    class="w-28 px-2 py-1 text-left font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">
                                    Login</th>
                                <th
                                    class="w-28 px-2 py-1 text-left font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide hidden sm:table-cell">
                                    Phone</th>
                                <th
                                    class="w-20 px-2 py-1 text-left font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">
                                    Dept</th>
                                <th
                                    class="w-20 px-2 py-1 text-left font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide hidden md:table-cell">
                                    Group</th>
                                <th
                                    class="w-20 px-2 py-1 text-left font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide hidden lg:table-cell">
                                    Trans</th>
                                <th
                                    class="w-20 px-2 py-1 text-left font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">
                                    Join</th>
                                <th
                                    class="w-24 px-2 py-1 text-left font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @for ($i = 0; $i < 3; $i++)
                                <tr class="animate-pulse">
                                    <td class="px-2 py-1">
                                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-8"></div>
                                    </td>
                                    <td class="px-2 py-1">
                                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-20"></div>
                                    </td>
                                    <td class="px-2 py-1">
                                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-20"></div>
                                    </td>
                                    <td class="px-2 py-1 hidden sm:table-cell">
                                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-20"></div>
                                    </td>
                                    <td class="px-2 py-1">
                                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-16"></div>
                                    </td>
                                    <td class="px-2 py-1 hidden md:table-cell">
                                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-16"></div>
                                    </td>
                                    <td class="px-2 py-1 hidden lg:table-cell">
                                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-16"></div>
                                    </td>
                                    <td class="px-2 py-1">
                                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-16"></div>
                                    </td>
                                    <td class="px-2 py-1">
                                        <div class="h-4 bg-gray-200 dark:bg-gray-700 rounded w-20"></div>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous" defer></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js" defer></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let searchTimeout;
            const table = $('#trashedEmployeesTable').DataTable({
                serverSide: true,
                ajax: {
                    url: '{{ route('employees.trashed') }}',
                    type: 'GET',
                    data: d => ({
                        search_name: $('#searchName').val(),
                        search_login: $('#searchLogin').val(),
                        search_phone: $('#searchPhone').val(),
                        _t: Date.now()
                    }),
                    error: xhr => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.error || 'Failed to load archived employees',
                            toast: true,
                            position: 'top-end',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }
                },
                columns: [
                    {
                        data: null,
                        render: (data, type, row, meta) => meta.row + 1 + meta.settings._iDisplayStart,
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'employee_name',
                        render: data => `<span class="truncate block max-w-[100px]" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`
                    },
                    {
                        data: 'employee_login',
                        render: data => `<span class="truncate block max-w-[100px]" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`
                    },
                    {
                        data: 'employee_phone',
                        className: 'hidden sm:table-cell'
                    },
                    {
                        data: 'department_name',
                        render: data => `<span class="truncate block max-w-[80px]" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`
                    },
                    {
                        data: 'work_group_name',
                        render: data => `<span class="truncate block max-w-[80px]" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`,
                        className: 'hidden md:table-cell'
                    },
                    {
                        data: 'transport_name',
                        render: data => `<span class="truncate block max-w-[80px]" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`,
                        className: 'hidden lg:table-cell'
                    },
                    { data: 'employee_joining_date' },
                    {
                        data: null,
                        render: (data, type, row) => `
                                <div class="flex gap-1">
                                    <form id="restore-employee-form-${row.employee_id}" action="{{ route('employees.restore', ':id') }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" onclick="confirmRestore(${row.employee_id})"
                                            class="px-1.5 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600 transition transform hover:scale-105 focus:outline-none focus:ring-1 focus:ring-blue-500"
                                            aria-label="Restore employee">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                        </button>
                                    </form>
                                    <form id="force-delete-employee-form-${row.employee_id}" action="{{ route('employees.forceDelete', ':id') }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmForceDelete(${row.employee_id})"
                                            class="px-1.5 py-1 bg-red-500 text-white rounded text-xs hover:bg-red-600 transition transform hover:scale-105 focus:outline-none focus:ring-1 focus:ring-red-500"
                                            aria-label="Permanently delete employee">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            `,
                        orderable: false,
                        searchable: false
                    }
                ],
                pageLength: 10,
                lengthMenu: [10, 20, 25, 50, 100],
                processing: true,
                order: [[1, 'asc']],
                language: {
                    processing: '<span class="text-gray-600 dark:text-gray-400">Loading...</span>',
                    emptyTable: 'No archived employees found'
                },
                initComplete: () => $('.animate-pulse').remove(),
                createdRow: (row) => $(row).addClass('hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors even:bg-gray-50 odd:bg-white dark:even:bg-gray-900 dark:odd:bg-gray-950')
            });

            // Search Debounce
            $('#searchName, #searchLogin, #searchPhone').on('keyup', function () {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => table.ajax.reload(), 300);
            });

            // Toast Fade
            const toast = document.getElementById('toastNotification');
            if (toast) {
                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
        });

        function escapeHtml(unsafe) {
            return unsafe
                ? String(unsafe)
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;")
                : '';
        }

        function confirmRestore(employeeId) {
            Swal.fire({
                title: 'Restore Employee?',
                text: 'This will restore the employee to the active list.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, restore',
                cancelButtonText: 'Cancel'
            }).then(result => {
                if (result.isConfirmed) {
                    const form = document.getElementById(`restore-employee-form-${employeeId}`);
                    if (form) {
                        form.action = form.action.replace(':id', employeeId);
                        form.submit();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Restore form not found. Please refresh and try again.',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                }
            }).catch(error => {
                console.error('Restore error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred.',
                    confirmButtonColor: '#dc2626'
                });
            });
        }

        function confirmForceDelete(employeeId) {
            Swal.fire({
                title: 'Permanently Delete?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel'
            }).then(result => {
                if (result.isConfirmed) {
                    const form = document.getElementById(`force-delete-employee-form-${employeeId}`);
                    if (form) {
                        form.action = form.action.replace(':id', employeeId);
                        form.submit();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Delete form not found. Please refresh and try again.',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                }
            }).catch(error => {
                console.error('Delete error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred.',
                    confirmButtonColor: '#dc2626'
                });
            });
        }
    </script>
@endpush