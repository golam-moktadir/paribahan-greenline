<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Driver;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\Transport;
use Illuminate\Http\Request;
use App\Services\DriverService;
use Illuminate\Support\Facades\Log;
use Exception;


class DriverController extends Controller
{
    protected $driverService;

    public function __construct(DriverService $driverService)
    {
        $this->driverService = $driverService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $request->ajax() ? $this->handleAjax($request) : view('drivers.index');
    }

    protected function handleAjax(Request $request)
    {
        try {
            $query = $this->driverService->getAllDrivers()
                ->select(
                    'drivers.id',
                    'drivers.full_name',
                    'drivers.id_no',
                    'drivers.phone',
                    'drivers.driving_license_no',
                    'drivers.status',
                    'drivers.joining_date',
                    'department.department_name',
                    'transport.transport_name'
                )
                ->leftJoin('department', 'drivers.department_id', '=', 'department.department_id')
                ->leftJoin('transport', 'drivers.transport_id', '=', 'transport.transport_id');

            $searchParams = [
                'searchName' => 'drivers.full_name',
                'searchIdNo' => 'drivers.id_no',
                'searchPhone' => 'drivers.phone',
                'searchDrivingLicenseNo' => 'drivers.driving_license_no',
            ];

            foreach ($searchParams as $input => $column) {
                if ($search = trim($request->input($input, ''))) {
                    $query->whereRaw("LOWER($column) LIKE ?", ['%' . strtolower($search) . '%']);
                }
            }

            // status filter
            if ($request->filled('searchStatus')) {
                $query->where('drivers.status', $request->input('searchStatus'));
            }

            $columns = [
                'drivers.id',
                'drivers.full_name',
                'drivers.id_no',
                'drivers.phone',
                'drivers.driving_license_no',
                'drivers.status',
                'department.department_name',
                'drivers.joining_date'
            ];
            // sorting
            $query->orderBy(
                $columns[$request->input('order.0.column', 1)] ?? 'drivers.full_name',
                $request->input('order.0.dir', 'asc')
            );

            $total = $this->driverService->getAllDrivers()->count();
            $filtered = $query->count();

            // pagination
            $drivers = $query->offset($request->input('start', 0))
                ->limit($request->input('length', 10))
                ->get();

            return response()->json([
                'draw' => $request->input('draw', 1),
                'recordsTotal' => $total,
                'recordsFiltered' => $filtered,
                'data' => $drivers->map(fn($driver) => [
                    'id' => $driver->id,
                    'full_name' => $driver->full_name ?? '',
                    'id_no' => $driver->id_no ?? '',
                    'phone' => $driver->phone ?? '',
                    'driving_license_no' => $driver->driving_license_no ?? '',
                    'status' => Driver::STATUSES[$driver->status] ?? 'Unknown',
                    'department_name' => $driver->department_name ?? '',
                    'joining_date' => $driver->joining_date?->format('d-m-Y') ?? '',
                    'actions' => view('drivers.partials.actions', ['driver' => $driver])->render(),
                ])->toArray(),
            ]);
        } catch (\Exception $e) {
            Log::error('Data AJAX error: ' . $e->getMessage());
            return response()->json([
                'draw' => $request->input('draw', 1),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Failed to load items.',
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $transports = Transport::all(); // may pass current logged in users transportation id
        $departments = Department::all();

        return view('drivers.create', compact('transports', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDriverRequest $request)
    {
        try {
            $itemValidatedData = $request->validated();
            $item = $this->driverService->createDriver($itemValidatedData);

            return redirect()
                ->route('drivers.index')
                ->with('success', [
                    'title' => $item->full_name ?? 'New Data',
                    'oldStatus' => null,
                    'newStatus' => 'Created Successfully',
                ]);
        } catch (\Exception $e) {

            Log::error('Data creation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'item_data' => $request->validated(),
            ]);

            return back()
                ->withInput()
                ->with('error', [
                    'title' => 'Creation Failed',
                    'oldStatus' => null,
                    'newStatus' => 'Failed to create data. Please try again.'
                ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($driver)
    {
        try {
            $item = $this->driverService->getDriverById($driver)->load(['transport', 'department', 'creator']);
            return view('drivers.show', compact('item'));
        } catch (\Exception $e) {
            return redirect()->route('drivers.index')->withErrors(['error' => 'Item not found.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($driver)
    {
        $item = $this->driverService->getDriverById($driver);

        return view('drivers.edit', [
            'item' => $item,
            'transports' => Transport::all(),
            'departments' => Department::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDriverRequest $request, $driver)
    {
        try {
            $item = $this->driverService->updateDriver($driver, $request->validated());

            return redirect()->route('drivers.index')->with('success', [
                'title' => $item->full_name ?? 'Updated Info',
                'oldStatus' => null,
                'newStatus' => 'Info Updated successfully!',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update info: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($driver)
    {
        try {
            $this->driverService->deleteDriver($driver);

            return redirect()->route('drivers.index')->with('success', [
                'title' => $driver->full_name ?? 'Item',
                'oldStatus' => 'Active',
                'newStatus' => 'Deleted'
            ]);
        } catch (Exception $e) {
            return redirect()->route('drivers.index')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function forceDelete($id)
    {
        try {
            $this->driverService->forceDeleteDriver($id);

            return redirect()->route('drivers.index')->with('success', [
                'title' => 'Item',
                'oldStatus' => 'Soft Deleted',
                'newStatus' => 'Permanently Deleted'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('drivers.index')->withErrors(['error' => 'Failed to force delete item.']);
        }
    }


    public function pdf($id)
    {
        $driver = $this->driverService->getDriverById($id)->load(['transport', 'department', 'creator']);
        $pdfContent = view('drivers.driver_cv', compact('driver'))->render();
        // Logic to compile $pdfContent with latexmk and return PDF
        return response()->streamDownload(function () use ($pdfContent) {
            // Output compiled PDF
        }, 'driver_cv_' . $driver->id . '.pdf', ['Content-Type' => 'application/pdf']);
    }
}
