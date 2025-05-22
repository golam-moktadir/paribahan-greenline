<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Member;
use App\Models\MemberType;
use App\Models\Transport;
use App\Models\WorkGroup;
use App\Services\EmployeeService;
use Illuminate\Http\RedirectResponse;
use EmployeeRequest;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;


class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    // employee list

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->handleAjaxRequest($request);
        }

        return view('employees.index');
    }

    protected function handleAjaxRequest(Request $request)
    {
        try {
            $validated = $this->validateRequest($request);
            $query = $this->buildQuery($validated);
            $totalRecords = $this->getTotalRecords();
            $filteredRecords = $this->getFilteredRecords($query, $validated);
            $employees = $this->getPaginatedEmployees($query, $validated);
            $data = $this->formatEmployeeData($employees);

            return response()->json([
                'draw' => $validated['draw'],
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            Log::error('DataTables AJAX error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'draw' => $request->input('draw', 1),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Failed to load employees. Please try again.'
            ], 500);
        }
    }


    protected function validateRequest(Request $request): array
    {
        return $request->validate([
            'draw' => 'required|integer|min:1',
            'start' => 'required|integer|min:0',
            'length' => 'required|integer|in:10,20,25,50,100,200',
            'search_global' => 'nullable|string|max:255',
            'search_name' => 'nullable|string|max:255',
            'search_login' => 'nullable|string|max:255',
            'search_phone' => 'nullable|string|max:11',
            'order.0.column' => 'required|integer|min:0|max:8',
            'order.0.dir' => ['required', Rule::in(['asc', 'desc'])],
        ]);
    }

    protected function buildQuery(array $validated): Builder
    {
        $query = $this->employeeService->getAllEmployees()
            ->select('employee.*')
            ->with([
                'department' => fn($q) => $q->select('department_id', 'department_name'),
                'workGroup' => fn($q) => $q->select('work_group_id', 'work_group_name'),
                'transport' => fn($q) => $q->select('transport_id', 'transport_name')
            ]);

        // Apply search filters
        $this->applySearchFilters($query, $validated);

        // Apply sorting
        $this->applySorting($query, $validated);

        return $query;
    }

    protected function applySearchFilters(Builder $query, array $validated): void
    {
        // Global search across multiple columns
        if ($globalSearch = trim($validated['search_global'] ?? '')) {
            $query->where(function ($q) use ($globalSearch) {
                $searchTerm = '%' . strtolower($globalSearch) . '%';
                $q->whereRaw('LOWER(employee_name) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(employee_login) LIKE ?', [$searchTerm])
                    ->orWhereRaw('LOWER(employee_phone) LIKE ?', [$searchTerm])
                    ->orWhereHas('department', fn($q) => $q->whereRaw('LOWER(department_name) LIKE ?', [$searchTerm]))
                    ->orWhereHas('workGroup', fn($q) => $q->whereRaw('LOWER(work_group_name) LIKE ?', [$searchTerm]))
                    ->orWhereHas('transport', fn($q) => $q->whereRaw('LOWER(transport_name) LIKE ?', [$searchTerm]));
            });
        }

        $filters = [
            'search_name' => 'employee_name',
            'search_login' => 'employee_login',
            'search_phone' => 'employee_phone',
        ];

        foreach ($filters as $input => $column) {
            if ($value = trim($validated[$input] ?? '')) {
                $query->whereRaw("LOWER({$column}) LIKE ?", ['%' . strtolower($value) . '%']);
            }
        }
    }

    protected function applySorting(Builder $query, array $validated): void
    {
        $columns = [
            0 => 'employee_id',
            1 => 'employee_name',
            2 => 'employee_login',
            3 => 'employee_phone',
            4 => 'employee_save_status',
            5 => 'department.department_name',
            6 => 'work_group.work_group_name',
            7 => 'transport.transport_name',
            8 => 'employee_joining_date',
        ];

        $orderColumnIndex = $validated['order'][0]['column'] ?? 1;
        $orderDirection = $validated['order'][0]['dir'] ?? 'asc';
        $orderColumn = $columns[$orderColumnIndex] ?? 'employee_name';

        if (str_contains($orderColumn, '.')) {
            [$table, $column] = explode('.', $orderColumn);
            $foreignKeyMap = [
                'department.department_name' => 'department_id',
                'work_group.work_group_name' => 'work_group_id',
                'transport.transport_name' => 'transport_id',
            ];
            $foreignKey = $foreignKeyMap[$orderColumn];
            $query->leftJoin($table, "employee.{$foreignKey}", '=', "{$table}.{$foreignKey}")
                ->orderBy("{$table}.{$column}", $orderDirection);
        } else {
            $query->orderBy("employee.{$orderColumn}", $orderDirection);
        }
    }

    protected function getTotalRecords(): int
    {
        return $this->employeeService->getAllEmployees()->count();
    }


    protected function getFilteredRecords(Builder $query, array $validated): int
    {
        return ($validated['search_name'] || $validated['search_login'] || $validated['search_phone'])
            ? $query->count()
            : $this->getTotalRecords();
    }

    protected function getPaginatedEmployees(Builder $query, array $validated): Collection
    {
        return $query->offset($validated['start'])
            ->limit($validated['length'])
            ->get();
    }

    protected function formatEmployeeData(Collection $employees): array
    {
        return $employees->map(fn($employee) => [
            'employee_id' => $employee->employee_id ?? '',
            'employee_name' => $employee->employee_name ?? '',
            'employee_login' => $employee->employee_login ?? '',
            'employee_phone' => $employee->employee_phone ?? '',
            'employee_save_status' => $employee->employee_save_status ?? '',
            'department_name' => optional($employee->department)->department_name ?? '',
            'work_group_name' => optional($employee->workGroup)->work_group_name ?? '',
            'transport_name' => optional($employee->transport)->transport_name ?? '',
            'employee_joining_date' => $employee->employee_joining_date?->format('d-m-Y') ?? '',
            'avatar_url' => $employee->avatar_url ?? '',
            'actions' => view('employees.partials.actions', ['employee' => $employee])->render(),
        ])->toArray();
    }


    // create

    public function create()
    {
        $memberTypes = MemberType::all();
        $transports = Transport::all(); // may pass current logged in users transportation id
        $departments = Department::all();
        $workGroups = WorkGroup::all();

        return view('employees.create', compact('memberTypes', 'transports', 'departments', 'workGroups'));
    }


    /**
     * Store a new employee and associated member record.
     *
     * @param StoreMemberRequest $memberRequest
     * @param StoreEmployeeRequest $employeeRequest
     * @return RedirectResponse
     */
    public function store(StoreMemberRequest $memberRequest, StoreEmployeeRequest $employeeRequest)
    {
        DB::beginTransaction();

        try {
            // Create member record
            $memberData = $memberRequest->validated();
            // dd($memberRequest);
            $member = Member::create([
                'member_type_id' => $memberData['member_type_id'],
                'member_login' => $memberData['member_login'],
                'member_email' => $memberData['member_email'] ?? null,
                'member_password' => $memberData['member_new_password'],
                'member_new_password' => $memberData['member_new_password'],
                'member_activation_id' => $memberData['member_activation_id'],
            ]);

            // Create employee record
            $employeeData = $employeeRequest->validated();
            $employeeData['member_id'] = $member->member_id; // Link employee to member
            $employee = $this->employeeService->createEmployee($employeeData);

            DB::commit();

            return redirect()
                ->route('employees.index')
                ->with('success', [
                    'title' => $employee->employee_name ?? 'New Employee',
                    'oldStatus' => null,
                    'newStatus' => 'Created Successfully',
                ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Employee creation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'member_data' => Arr::except($memberRequest->validated(), ['member_new_password']),
                'employee_data' => $employeeRequest->validated(),
            ]);

            return back()
                ->withInput()
                ->with('error', [
                    'title' => 'Creation Failed',
                    'oldStatus' => null,
                    'newStatus' => 'Failed to create employee. Please try again.'
                ]);
        }

    }


    public function show($id)
    {
        // dd($employee = $this->employeeService->getEmployeeById($id));

        try {
            $employee = $this->employeeService->getEmployeeById($id);
            return view('employees.show', compact('employee'));
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->withErrors(['error' => 'Employee not found.']);
        }
    }

    public function edit($id)
    {
        $employee = $this->employeeService->getEmployeeById($id);

        return view('employees.edit', [
            'employee' => $employee,
            'member' => $employee->member,
            'transports' => Transport::all(),
            'departments' => Department::all(),
            'workGroups' => WorkGroup::all(),
        ]);
    }

    public function update(UpdateEmployeeRequest $request, $employee)
    {
        try {
            $employee = $this->employeeService->updateEmployee($employee, $request->validated());

            return redirect()->route('employees.index')->with('success', [
                'title' => $employee->employee_name ?? 'Updated Employee',
                'oldStatus' => null,
                'newStatus' => 'Employee updated successfully!',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update employee: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->employeeService->deleteEmployee($id);

            return redirect()->route('employees.index')->with('success', [
                'title' => $employee->employee_name ?? 'Employee',
                'oldStatus' => 'Active',
                'newStatus' => 'Deleted'
            ]);
        } catch (Exception $e) {
            return redirect()->route('employees.index')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function forceDelete($id)
    {
        try {
            $this->employeeService->forceDeleteEmployee($id);

            return redirect()->route('employees.index')->with('success', [
                'title' => 'Employee',
                'oldStatus' => 'Soft Deleted',
                'newStatus' => 'Permanently Deleted'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->withErrors(['error' => 'Failed to force delete employee.']);
        }
    }


    public function updateStatus($id)
    {
        try {
            $employee = $this->employeeService->getEmployeeById($id);

            // Determine old and new status
            $oldStatus = $employee->employee_save_status ? 'Unblocked' : 'Blocked'; // Old status
            $newStatus = !$employee->employee_save_status ? 'Unblocked' : 'Blocked'; // New status

            // Update status
            $this->employeeService->updateEmployee($id, ['employee_save_status' => !$employee->employee_save_status]);

            return redirect()->route('employees.index')->with('success', [
                'title' => $employee->employee_name,
                'oldStatus' => $oldStatus,
                'newStatus' => $newStatus
            ]);
        } catch (\Exception $e) {
            return redirect()->route('employees.index')->withErrors(['error' => 'Failed to update employee status.']);
        }
    }

}