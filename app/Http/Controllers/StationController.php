<?php

namespace App\Http\Controllers;
use App\Models\City;
use App\Models\Station;
use App\Services\StationService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Exception;

class StationController extends Controller
{

    protected $service;
    protected $resource = 'stations';
    protected $perPage = 10;

    public function __construct(StationService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): View|JsonResponse
    {
        return $request->ajax() ? $this->handleDataTableRequest($request) : view("{$this->resource}.index", ['resource' => $this->resource]);
    }

    protected function handleDataTableRequest(Request $request): JsonResponse
    {

        try {
            $query = $this->service->getAllItems();
            $this->applyFilters($query, $request);
            $total = $query->count();
            $filtered = $query->count();
            $results = $this->applyPagination($query, $request);

            $response = [
                'draw' => (int) $request->input('draw', 1),
                'recordsTotal' => $total,
                'recordsFiltered' => $filtered,
                'data' => $results->map(function ($item) {
                    return [
                        'station_id' => $item->station_id,
                        'city_name' => $item->city->city_name,
                        'station_name' => $item->station_name,
                        'station_location' => $item->station_location,
                        'actions' => view('components.datatable.actions', [
                            'resource' => $this->resource,
                            'id' => $item->station_id,
                            'show' => false,
                            'edit' => true,
                            'delete' => false,
                        ])->render(),
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
            'station.station_id',
            'station.station_name',
            'station.station_location'
        ];

        $orderColumnIndex = (int) $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'desc');
        $orderColumn = $columns[$orderColumnIndex] ?? 'station.station_id';

        if ($orderColumnIndex === 1 || $orderColumnIndex === 2) {
            $query->orderBy(Station::select('station_name')->take(1), $orderDir);
        } else {
            $query->orderBy($orderColumn, $orderDir);
        }

        return $query->offset((int) $request->input('start', 0))
            ->limit((int) $request->input('length', $this->perPage))
            ->get();
    }

    protected function applyFilters($query, Request $request): void
    {
        if ($request->filled('station_name')) {
            $query->where('station_name', 'like', '%' . $request->station_name . '%');
        }
    }

    public function create(){
        $cities = City::get();
        return view('stations.create', ['cities' => $cities, 'resource' => $this->resource]);
    }

    public function store(Request $request){

        $request->validate([
            'city_id' => 'required|integer',
            'station_name' => 'required|string',
            'station_location' => 'required|string'
        ]);

        DB::beginTransaction();

        try{
            $station = new Station();
            $station->city_id  = $request->city_id;
            $station->station_name = $request->station_name;
            $station->station_location = $request->station_location;
            $station->save();

            DB::commit();
            return redirect()->route($this->resource.'.index')->with('success', [
                'title' => 'New Station',
                'oldStatus' => null,
                'newStatus' => 'Created Successfully',
            ]);
        } 
        catch (Exception $e){
            DB::rollBack();
            return back()->withInput()->with('error', [
                'title' => 'Creation Failed',
                'oldStatus' => null,
                'newStatus' => 'Failed to create Station. Please try again.'
            ]);
        }
    }

    public function edit(int $id): View|RedirectResponse
    {
        $cities = City::all();
        $single = Station::findOrFail($id);
        return view('stations.edit', ['single' => $single, 'cities' => $cities, 'resource' => $this->resource]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {

        $request->validate([
            'city_id' => 'required|integer',
            'station_name' => 'required|string',
            'station_location' => 'required|string'
        ]);
        DB::beginTransaction();

        try{
            $station = Station::find($id);
            $station->city_id  = $request->city_id;
            $station->station_name = $request->station_name;
            $station->station_location = $request->station_location;
            $station->save();

            DB::commit();
            return redirect()->route($this->resource.'.index')->with('success', [
                'title' => 'New Station',
                'oldStatus' => null,
                'newStatus' => 'Created Successfully',
            ]);
        } 
        catch (Exception $e){
            DB::rollBack();
            return back()->withInput()->with('error', [
                'title' => 'Creation Failed',
                'oldStatus' => null,
                'newStatus' => 'Failed to create Station. Please try again.'
            ]);
        }
    }
}
