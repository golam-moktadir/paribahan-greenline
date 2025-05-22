<?php

namespace App\Http\Controllers;
use App\Models\City;
use App\Models\Station;
use App\Models\Employee;
use App\Models\Booth;
use App\Http\Requests\StoreBoothRequest;
use App\Http\Requests\UpdateBoothRequest;
use App\Services\BoothService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Exception;

class BoothController extends Controller
{

    protected $service;
    protected $resource = 'booths';
    protected $perPage = 10;

    public function __construct(BoothService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): View|JsonResponse
    {
        return $request->ajax()
            ? $this->handleDataTableRequest($request)
            : view("{$this->resource}.index", ['resource' => $this->resource]);
    }

    protected function handleDataTableRequest(Request $request): JsonResponse
    {
        try {
            $query = $this->service->getAllItems();
            $this->applyFilters($query, $request);
            $total = $this->service->getAllItems()->count();
            $filtered = $query->count();
            $results = $this->applyPagination($query, $request);

            $response = [
                'draw' => (int) $request->input('draw', 1),
                'recordsTotal' => $total,
                'recordsFiltered' => $filtered,
                'data' => $results->map(function ($item) {
                    return [
                        'booth_id' => $item->booth_id,
                        'city_name' => $item->station->city->city_name,
                        'station_name' => $item->station->station_name,
                        'booth_name' => $item->booth_name,
                        'booth_address' => $item->booth_address,
                        'actions' => view('components.datatable.actions-block', [
                            'resource' => $this->resource,
                            'id' => $item->booth_id,
                            'show' => true,
                            'edit' => true,
                            'delete' => false,
                            'booth_block' => $item->booth_block
                        ])->render()
                    ];
                })->toArray()
            ];
            return response()->json($response);

        } catch (Exception $e) {
            Log::error("data table error: {$e->getMessage()}", [
                'request' => $request->all(),
                'stack' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'draw' => (int) $request->input('draw', 1),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => "Failed to load data.",
            ], 500);
        }
    }

    protected function applyPagination($query, Request $request)
    {
        $columns = [
            'booth.booth_id',
            'booth.city_name',
            //'booth.station_id',
            'booth.booth_address'
        ];

        $orderColumnIndex = (int) $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'desc');
        $orderColumn = $columns[$orderColumnIndex] ?? 'booth.booth_id';

        if ($orderColumnIndex === 1 || $orderColumnIndex === 2) {
            $query->orderBy(Booth::select('booth_name')->take(1), $orderDir);
        } else {
            $query->orderBy($orderColumn, $orderDir);
        }

        return $query->offset((int) $request->input('start', 0))
            ->limit((int) $request->input('length', $this->perPage))
            ->get();
    }

    protected function applyFilters($query, Request $request): void
    {
        if ($station_name = $request->station_name) {
            $query->whereHas('station', function ($q) use ($station_name) {
                $q->whereRaw('station_name LIKE ?', ['%' . $station_name . '%']);
            });
        }

        if ($request->filled('booth_name')) {
            $query->where('booth_name', 'like', '%' . $request->booth_name . '%');
        }
    }

    public function create()
    {
        $cities = City::all();
        $employees = Employee::all();
        $booths = Booth::all();
        $stations = Station::all();
        $booth_code = Booth::max('booth_code');
        return view('booths.create', compact('cities', 'employees', 'booths', 'stations', 'booth_code'));
    }

    public function getAllStation(Request $request)
    {
        $stations = Station::where('city_id', $request->city_id)->get();

        $options = "<option value=''>--Select Station--</option>";
        foreach ($stations as $station) {
            $options .= "<option value='" . $station->station_id . "'>$station->station_name</option>";
        }
        return response()->json($options);
    }

    public function store(StoreBoothRequest $request)
    {

        DB::beginTransaction();

        try {
            $item = $this->service->createBooth($request->validated());
            DB::commit();

            return redirect()->route('booths.index')->with('success', [
                'title' => 'New Booth',
                'oldStatus' => null,
                'newStatus' => 'Created Successfully',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('creation failed: ' . $e->getMessage());

            return back()->withInput()->with('error', [
                'title' => 'Creation Failed',
                'oldStatus' => null,
                'newStatus' => 'Failed to create booth. Please try again.'
            ]);
        }
    }

    public function show(int $id): View|RedirectResponse
    {
        try {
            $booth = $this->service->getItemById($id);
            return view("{$this->resource}.show", ['booth' => $booth]);

        } catch (Exception $e) {

            Log::warning("{$this->resource} #{$id} not found: {$e->getMessage()}");

            return $this->redirectWithError(
                "Failed",
                null,
                "{$this->resource} not found: {$e->getMessage()}"
            );
        }
    }

    public function edit(int $id): View|RedirectResponse
    {
        $cities = City::all();
        $employees = Employee::all();
        $booths = Booth::all();
        $booth = Booth::findOrFail($id);
        return view('booths.edit', compact('cities', 'employees', 'booths', 'booth'));
    }

    public function update(UpdateBoothRequest $request, int $id): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $item = $this->service->updateItem($id, $request->validated());
            DB::commit();

            return redirect()->route('booths.index')->with('success', [
                'title' => 'Edit Booth',
                'oldStatus' => null,
                'newStatus' => 'Updated Successfully',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('update failed: ' . $e->getMessage());

            return back()->withInput()->with('error', [
                'title' => 'Updated Failed',
                'oldStatus' => null,
                'newStatus' => 'Failed to update booth. Please try again.'
            ]);
        }
    }

    public function toggle($id)
    {
        $booth = Booth::findOrFail($id);
        $booth->booth_block = $booth->booth_block == 1 ? 0 : 1; // toggle
        $booth->save();

        return redirect()->route('booths.index')->with('success', [
            'title' => null,
            'oldStatus' => null,
            'newStatus' => 'Booth status updated.',
        ]);
    }

}
