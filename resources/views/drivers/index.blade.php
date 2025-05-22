@extends('layouts.app')

@section('title', 'Drivers')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/package/dist/sweetalert2.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/css/components/datatable.css') }}" as="style">
    <style>
        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-info {
            background-color: #17a2b8;
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto">
        <x-alert.toast-notification :success="session('success')" :error="$errors->first('error')" />
        <div class="data-table-container">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                    <x-datatable.search-input id="searchName" placeholder="Search by Name" icon="fas fa-search" />
                    <x-datatable.search-input id="searchIdNo" placeholder="Search by ID No." icon="fa fa-id-badge" />
                    <x-datatable.search-input id="searchPhone" placeholder="Search by Phone" icon="fa fa-phone" />
                    <x-datatable.search-input id="searchDrivingLicenseNo" placeholder="Driving License No."
                        icon="fas fa-car" />
                    <x-form.select-input id="filterStatus" :options="\App\Models\Driver::STATUSES" :value="request('filterStatus')"
                        placeholder="Filter by Status" icon="fas fa-filter" />
                </div>
                <a href="{{ route('drivers.create') }}"
                    class="action-btn bg-gradient-to-r from-blue-500 to-blue-600 text-white hover:from-blue-600 hover:to-blue-700 shadow hover:shadow-md px-4 py-2 rounded">
                    <i class="fas fa-plus"></i> Add Driver
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
                ['data' => 'full_name', 'render' => 'truncate', 'title' => 'Full Name', 'width' => 'w-28'],
                ['data' => 'id_no', 'title' => 'ID No.', 'width' => 'w-28'],
                ['data' => 'phone', 'className' => 'sm-hidden', 'title' => 'Phone', 'width' => 'w-28'],
                [
                    'data' => 'driving_license_no',
                    'className' => 'sm-hidden',
                    'title' => 'Driving License No.',
                    'width' => 'w-28',
                ],
                ['data' => 'status', 'className' => 'sm-hidden', 'title' => 'Status', 'width' => 'w-20'],
                ['data' => 'department_name', 'title' => 'Dept', 'width' => 'w-20'],
                ['data' => 'joining_date', 'title' => 'Join', 'width' => 'w-20'],
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
        function setupTable() {
            const table = $('#driversTable').DataTable({
                serverSide: true,
                ajax: {
                    url: '{{ route('drivers.index') }}',
                    type: 'GET',
                    data: function(d) {
                        d.searchName = $('#searchName').val();
                        d.searchIdNo = $('#searchIdNo').val();
                        d.searchPhone = $('#searchPhone').val();
                        d.searchDrivingLicenseNo = $('#searchDrivingLicenseNo').val();
                        d.searchStatus = $('#filterStatus').val();
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1 + meta.settings._iDisplayStart;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'full_name',
                        render: function(data) {
                            return `<span class="truncate block max-w-[100px]" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`;
                        }
                    },
                    {
                        data: 'id_no',
                        render: function(data) {
                            return `<span class="block max-w-[100px]" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`;
                        }
                    },
                    {
                        data: 'phone',
                        className: 'sm-hidden'
                    },
                    {
                        data: 'driving_license_no',
                    },
                    {
                        data: 'status',
                        className: 'sm-hidden',
                        render: function(data) {
                            const statusClasses = {
                                'Inactive': 'badge-danger',
                                'Active': 'badge-success',
                                'On-Leave': 'badge-warning',
                                'On-Review': 'bg-blue-100 text-blue-800',
                                'On-Hold': 'bg-gray-300 text-gray-800',
                                'Terminated': 'badge-secondary',
                                'Accident': 'bg-red-300 text-blue-800',
                                'Retired': 'bg-red-600 text-white-800',
                                'Death': 'bg-red-800 text-white-800',
                                'Unknown': 'badge-info'
                            };
                            const statusClass = statusClasses[data] || 'badge-info';
                            return `<span class="badge ${statusClass}">${escapeHtml(data)}</span>`;
                        }
                    },
                    {
                        data: 'department_name',
                        render: function(data) {
                            return `<span class="block max-w-[80px]" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`;
                        }
                    },
                    {
                        data: 'joining_date'
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
                createdRow: function(row) {
                    $(row).addClass('hover:bg-gray-100 transition-colors even:bg-gray-50 odd:bg-white');
                }
            });

            // Search and filter debounce
            let searchTimeout;
            $('#searchName, #searchIdNo, #searchPhone, #searchDrivingLicenseNo').on('keyup', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => table.ajax.reload(), 300);
            });

            $('#filterStatus').on('change', function() {
                table.ajax.reload();
            });
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

        // Initialize table when jQuery is loaded
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
                    loadScript("{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}", setupTable);
                });
            } else {
                loadScript("{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}", setupTable);
            }
        })();

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

        async function confirmDelete(driverId) {
            try {
                await loadSweetAlert();

                const result = await Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will permanently delete the driver. This cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                });

                if (result.isConfirmed) {
                    const form = document.getElementById(`delete-driver-form-${driverId}`);
                    if (form) {
                        form.submit();
                    } else {
                        console.error(`Form with ID delete-driver-form-${driverId} not found`);
                        await Swal.fire({
                            title: 'Error',
                            text: 'Delete form not found. Please refresh and try again.',
                            icon: 'error',
                            confirmButtonColor: '#dc2626'
                        });
                    }
                }
            } catch (error) {
                console.error('Unexpected error in confirmDelete:', error);
                await Swal.fire({
                    title: 'Error',
                    text: 'An unexpected error occurred. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#dc2626'
                });
            }
        }

        try {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action will permanently delete the driver. This cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Find the form using driverId
                    const form = document.getElementById(`delete-driver-form-${driverId}`);
                    if (form) {
                        form.submit();
                    } else {
                        console.error(`Form with ID delete-driver-form-${driverId} not found`);
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
    </script>
@endpush
