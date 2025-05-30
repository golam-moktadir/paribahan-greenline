@extends('layouts.app')

@section('title', 'Offences')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables/jquery.dataTables.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/package/dist/sweetalert2.min.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('assets/css/components/datatable.css') }}" as="style">
    <style>
        /* Status badge styles */
        .badge-pending {
            background-color: #fefcbf;
            color: #744210;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-review {
            background-color: #bfdbfe;
            color: #1e40af;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-action {
            background-color: #fed7aa;
            color: #c2410c;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-unknown {
            background-color: #f3f4f6;
            color: #4b5563;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Truncate long text */
        .truncate-cell {
            display: block;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Action button */
        .action-btn {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(to right, #3b82f6, #2563eb);
            color: #ffffff;
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background 0.2s, box-shadow 0.2s;
        }

        .action-btn:hover {
            background: linear-gradient(to right, #2563eb, #1e40af);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
        }

        /* Search and select inputs */
        .select-input {
            width: 100%;
            max-width: 12rem;
            padding: 0.35rem 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.25rem;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .select-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }

        .select-input-container {
            position: relative;
        }

        .select-input-icon {
            position: absolute;
            left: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto">
        <x-alert.toast-notification :success="session('success')" :error="session('error')" />

        <div class="data-table-container bg-white shadow rounded-lg overflow-hidden">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-1 border-b border-gray-200 gap-4">
                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                    <x-datatable.search-input id="searchIdNo" placeholder="Search by Driver ID No."
                        icon="fas fa-id-badge" />

                    <div class="select-input-container">
                        <span class="select-input-icon"><i class="fas fa-filter"></i></span>
                        <x-form.select-input id="searchStatus" :options="\App\Models\Offence::getOffenceTypeLabels()" :value="request('searchStatus')"
                            placeholder="Filter by Offence Type" icon="fas fa-filter" class="select-input pl-10"
                            aria-label="Filter by Offence Type" />
                    </div>

                    <x-datatable.date-range-input id="dateRange" startId="startDate" endId="endDate"
                        startPlaceholder="Start Date" endPlaceholder="End Date" icon="fas fa-calendar" />
                </div>
                <a href="{{ route($resource . '.create') }}" class="action-btn">
                    <i class="fas fa-plus"></i> Add Offence
                </a>
            </div>
            <div class="overflow-x-auto mt-1">
                <x-datatable.data-table id="offencesTable" :columns="[
                    [
                        'data' => null,
                        'render' => 'rowIndex',
                        'orderable' => false,
                        'searchable' => false,
                        'title' => 'ID',
                        'className' => 'w-12',
                    ],
                    ['data' => 'driver_id_no', 'title' => 'Driver ID No.', 'className' => 'w-28'],
                    [
                        'data' => 'driver_full_name',
                        'render' => 'truncate',
                        'title' => 'Driver Name',
                        'className' => 'w-28',
                    ],
                    ['data' => 'occurrence_date', 'title' => 'Occurrence Date', 'className' => 'w-28'],
                    ['data' => 'offence_type', 'title' => 'Type', 'className' => 'w-20'],
                    ['data' => 'complainant_phone', 'title' => 'Complainant Phone', 'className' => 'w-28'],
                    ['data' => 'description', 'render' => 'truncate', 'title' => 'Description', 'className' => 'w-32'],
                    [
                        'data' => 'actions',
                        'orderable' => false,
                        'searchable' => false,
                        'title' => 'Actions',
                        'className' => 'w-24',
                    ],
                ]" ajax="{{ route($resource . '.index') }}"
                    aria-label="Offence Table" />
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/jquery/jquery-3-7-1.min.js') }}" defer></script>
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}" defer></script>
    <script src="{{ asset('assets/vendor/sweetalert/package/dist/sweetalert2.min.js') }}" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Initializing Offence DataTable');

            const table = $('#offencesTable').DataTable({
                serverSide: true,
                ajax: {
                    url: '{{ route($resource . '.index') }}',
                    type: 'GET',
                    data: function(d) {
                        const params = {
                            ...d,
                            searchIdNo: $('#searchIdNo').val(),
                            searchStatus: $('#searchStatus').val(),
                            startDate: $('#startDate').val(),
                            endDate: $('#endDate').val(),
                        };
                        console.log('DataTable AJAX request params:', params);
                        return params;
                    },
                    dataSrc: function(json) {
                        console.log('DataTable AJAX response:', json);
                        if (json.error) {
                            console.error('DataTable error in response:', json.error);
                        }
                        return json.data;
                    },
                    error: function(xhr, error, thrown) {
                        console.error('DataTable AJAX error:', {
                            xhr,
                            error,
                            thrown
                        });
                        Swal.fire({
                            title: 'Error',
                            text: 'Failed to load Offences. Please try again.',
                            icon: 'error',
                            confirmButtonColor: '#dc2626',
                            toast: true,
                            position: 'top-end',
                            timer: 3000,
                            showConfirmButton: true,
                            confirmButtonText: 'Retry',
                            didClose: () => {
                                console.log('Retrying DataTable reload');
                                table.ajax.reload();
                            }
                        });
                    },
                },
                columns: [{
                        data: null,
                        render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1,
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'driver_id_no',
                        render: (data) =>
                            `<span class="truncate-cell" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`,
                    },
                    {
                        data: 'driver_full_name',
                        render: (data) =>
                            `<span class="truncate-cell" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`,
                    },
                    {
                        data: 'occurrence_date',
                        render: (data) => escapeHtml(data),
                    },
                    {
                        data: 'offence_type',
                        render: (data) => {
                            const statusMap = {
                                'pending': ['pending', 'Pending'],
                                'review': ['review', 'Review'],
                                'action': ['action', 'Action'],
                            };
                            const [statusClass, statusText] = statusMap[data] || ['unknown', data ||
                                'Unknown'
                            ];
                            return `<span class="badge badge-${statusClass}">${escapeHtml(statusText)}</span>`;
                        },
                    },
                    {
                        data: 'complainant_phone',
                        render: (data) => escapeHtml(data),
                    },
                    {
                        data: 'description',
                        render: (data) =>
                            `<span class="truncate-cell" title="${escapeHtml(data)}">${escapeHtml(data)}</span>`,
                    },
                    {
                        data: 'actions',
                        orderable: false,
                        searchable: false,
                    },
                ],
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                processing: true,
                order: [
                    [0, 'desc']
                ],
                language: {
                    processing: '<span class="text-gray-600">Loading...</span>',
                    emptyTable: 'No Offence found',
                },
                createdRow: (row) => {
                    $(row).addClass('hover:bg-gray-100 transition-colors even:bg-gray-50 odd:bg-white');
                    $(row).attr('role', 'row');
                    console.log('DataTable row created:', row);
                },
                responsive: true,
            });

            let searchTimer;
            $('#searchIdNo, #searchStatus, #startDate, #endDate').on('input change', function() {
                clearTimeout(searchTimer);
                const startDate = $('#startDate').val();
                const endDate = $('#endDate').val();
                if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
                    Swal.fire({
                        title: 'Invalid Date Range',
                        text: 'End date cannot be before start date.',
                        icon: 'error',
                        confirmButtonColor: '#dc2626',
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                        showConfirmButton: false
                    });
                    $('#endDate').val('');
                    return;
                }
                searchTimer = setTimeout(() => {
                    table.ajax.reload();
                }, 300);
            });
        });

        function escapeHtml(unsafe) {
            if (unsafe === null || unsafe === undefined) return '';
            return String(unsafe)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        window.confirmAction = async function(action, id, resource, actionText = 'delete') {
            try {
                const result = await Swal.fire({
                    title: `Are you sure you want to ${actionText} this data?`,
                    text: `This action cannot be undone!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: `Yes, ${actionText} it!`,
                    cancelButtonText: 'Cancel'
                });

                if (result.isConfirmed) {
                    const form = document.getElementById(`${action}-${resource}-form-${id}`);
                    if (form) {
                        console.log(`Submitting ${action} form for ${resource} #${id}`);
                        form.submit();
                    } else {
                        console.error(`Form with ID ${action}-${resource}-form-${id} not found`);
                        await Swal.fire({
                            title: 'Error',
                            text: `Form not found. Please refresh and try again.`,
                            icon: 'error',
                            confirmButtonColor: '#dc2626',
                            toast: true,
                            position: 'top-end',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }
                } else {
                    console.log(`${actionText} action cancelled for ${resource} #${id}`);
                }
            } catch (error) {
                console.error(`Error in ${actionText} action:`, error);
                await Swal.fire({
                    title: 'Error',
                    text: 'An unexpected error occurred. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#dc2626',
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        };
    </script>
@endpush
