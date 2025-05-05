@extends('layouts.app')

@section('title', 'Drivers')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/package/dist/sweetalert2.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/css/components/datatable.css') }}" as="style">
@endpush

@section('content')
    <div class="container mx-auto">
        <x-alert.toast-notification :success="session('success')" :error="$errors->first('error')" />
        <div class="data-table-container">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                    <x-datatable.search-input id="searchName" placeholder="Search by Name" icon="fas fa-search" />
                    <x-datatable.search-input id="searchLogin" placeholder="Search by Login" icon="fas fa-user" />
                    <x-datatable.search-input id="searchPhone" placeholder="Search by Phone" icon="fas fa-phone" />
                </div>
                <a href="{{ route('drivers.create') }}"
                    class="action-btn bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 shadow hover:shadow-md">
                    <i class="fas fa-plus"></i> Add New
                </a>
            </div>
            <x-datatable.data-table id="driversTable" :columns="[
                [
                    'data' => null,
                    'render' => 'rowIndex',
                    'orderable' => false,
                    'searchable' => false,
                    'title' => 'ID',
                    'width' => 'w-12',
                ],
                ['data' => 'employee_name', 'render' => 'truncate', 'title' => 'Name', 'width' => 'w-28'],
                ['data' => 'employee_login', 'render' => 'truncate', 'title' => 'Login', 'width' => 'w-28'],
                ['data' => 'employee_phone', 'className' => 'sm-hidden', 'title' => 'Phone', 'width' => 'w-28'],
                ['data' => 'employee_save_status', 'className' => 'sm-hidden', 'title' => 'Status', 'width' => 'w-28'],
                ['data' => 'department_name', 'render' => 'truncate', 'title' => 'Dept', 'width' => 'w-20'],
                [
                    'data' => 'work_group_name',
                    'render' => 'truncate',
                    'className' => 'md-hidden',
                    'title' => 'Group',
                    'width' => 'w-20',
                ],
                [
                    'data' => 'transport_name',
                    'render' => 'truncate',
                    'className' => 'lg-hidden',
                    'title' => 'Trans',
                    'width' => 'w-20',
                ],
                ['data' => 'employee_joining_date', 'title' => 'Join', 'width' => 'w-20'],
                [
                    'data' => 'actions',
                    'orderable' => false,
                    'searchable' => false,
                    'title' => 'Actions',
                    'width' => 'w-24',
                ],
            ]" ajax="{{ route('drivers.index') }}" />
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/sweetalert/package/custom.min.js') }}" defer></script>
    <script>
        // Load jQuery with fallback
        (function() {
            function loadScript(src, callback) {
                const script = document.createElement('script');
                script.src = src;
                script.onload = callback;
                script.async = true;
                document.head.appendChild(script);
            }

            if (!window.jQuery) {
                loadScript("{{ asset('assets/vendor/jquery/jquery-3-7-1.min.js') }}", function() {
                    initDataTable();
                });
            } else {
                initDataTable();
            }

            function initDataTable() {
                loadScript("{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}", function() {
                    setupTable();
                });
            }
        })();

        function setupTable() {
            const defaultAvatar = "{{ asset('images/default-avatar.jpg') }}";
            let searchTimeout;
            const table = $('#driversTable').DataTable({
                serverSide: true,
                ajax: {
                    url: '{{ route('drivers.index') }}',
                    type: 'GET',
                    data: function(d) {
                        d.search_name = $('#searchName').val();
                        d.search_login = $('#searchLogin').val();
                        d.search_phone = $('#searchPhone').val();
                        d._t = Date.now(); // Cache buster
                    },
                    error: function(xhr) {
                        console.error('DataTables error:', xhr.responseText);
                        if (window.Swal) {
                            showErrorAlert(xhr.responseJSON?.error || 'Failed to load data');
                        } else {
                            loadSweetAlert().then(() => {
                                showErrorAlert(xhr.responseJSON?.error ||
                                    'Failed to load data');
                            });
                        }
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1 + meta.settings._iDisplayStart;
                        },
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'employee_name',
                        render: function(data) {
                            return `<span class="truncate block max-w-[100px]" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`;
                        }
                    },
                    {
                        data: 'employee_login',
                        render: function(data) {
                            return `<span class="truncate block max-w-[100px]" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`;
                        }
                    },
                    {
                        data: 'employee_phone',
                        className: 'sm-hidden'
                    },
                    {
                        data: 'employee_save_status',
                        className: 'sm-hidden',
                        render: function(data, type, row) {
                            if (data == 1) {
                                return '<span class="badge badge-success">Unblocked</span>';
                            } else if (data == 0) {
                                return '<span class="badge badge-danger">Blocked</span>';
                            } else {
                                return '<span class="badge badge-secondary">Unknown</span>';
                            }
                        }
                    },
                    {
                        data: 'department_name',
                        render: function(data) {
                            return `<span class="truncate block max-w-[80px]" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`;
                        }
                    },
                    {
                        data: 'work_group_name',
                        render: function(data) {
                            return `<span class="truncate block max-w-[80px]" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`;
                        },
                        className: 'md-hidden'
                    },
                    {
                        data: 'transport_name',
                        render: function(data) {
                            return `<span class="truncate block max-w-[80px]" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`;
                        },
                        className: 'lg-hidden'
                    },
                    {
                        data: 'employee_joining_date'
                    },
                    {
                        data: 'actions',
                        orderable: false,
                        searchable: false
                    }
                ],
                pageLength: 10,
                lengthMenu: [10, 20, 25, 50, 100],
                processing: true,
                order: [
                    [1, 'asc']
                ],
                language: {
                    processing: '<span class="text-gray-600">Loading...</span>',
                    emptyTable: 'No drivers found'
                },
                initComplete: function() {
                    // Remove skeleton rows after table loads
                    $('.skeleton').closest('tr').remove();
                },
                createdRow: function(row) {
                    $(row).addClass('hover:bg-gray-100 transition-colors even:bg-gray-50 odd:bg-white');
                }
            });

            // Search debounce
            $('#searchName, #searchLogin, #searchPhone').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => table.ajax.reload(), 300);
            });

            // Handle toast notification
            const toast = document.getElementById('toastNotification');
            if (toast) {
                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 3000);
            }
        }

        function escapeHtml(unsafe) {
            return unsafe ?
                unsafe.toString()
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;") :
                '';
        }

        function loadSweetAlert() {
            return new Promise((resolve) => {
                if (window.Swal) {
                    resolve();
                } else {
                    const script = document.createElement('script');
                    // script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                    script.src = "{{ asset('assets/vendor/sweetalert/package/custom.min.js') }}";
                    script.onload = resolve;
                    document.head.appendChild(script);
                }
            });
        }

        function showErrorAlert(message) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                toast: true,
                position: 'top-end',
                timer: 3000,
                showConfirmButton: false
            });
        }

        function confirmDelete(employeeId) {
            try {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will permanently delete the employee. This cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Find the form using employeeId
                        const form = document.getElementById(`delete-employee-form-${employeeId}`);
                        if (form) {
                            form.submit();
                        } else {
                            console.error(`Form with ID delete-employee-form-${employeeId} not found`);
                            Swal.fire({
                                title: 'Error',
                                text: 'Unable to find the delete form. Please refresh the page and try again.',
                                icon: 'error',
                                confirmButtonColor: '#dc2626'
                            });
                        }
                    }
                });
            } catch (error) {
                console.error('Error in confirmDelete:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'An unexpected error occurred. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#dc2626'
                });
            }
        }
    </script>
@endpush
