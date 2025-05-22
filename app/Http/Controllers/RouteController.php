<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RouteController extends Controller
{
    protected $resource = 'routes';
    protected $perPage = 10;

    public function index()
    {
        return view($this->resource.".index", ['resource' => $this->resource]);
    }

    public function getAllData(Request $request){
        
        try {
            $query = Route::query()->where('return_route_id', 0)
                                    ->select([
                                        'route_id',
                                        'route_name',
                                        'route_departure_desc',
                                        'route_block as item_block'
                                    ]);
            //$this->applyFilters($query, $request);
            $total = $query->count();
            $filtered = $query->count();
            $results = $this->applyPagination($query, $request);

            $response = [
                'draw' => (int) $request->input('draw', 1),
                'recordsTotal' => $total,
                'recordsFiltered' => $filtered,
                'data' => $results->map(function ($item) {
                    $routes = explode(" - ", $item->route_name);

                    $cities = [];
                    $index = 0;
                    foreach($routes as $route){
                        $cities[$index] = City::where('city_id', $route)->value('city_name');
                        $index++;
                    }
                    return [
                        'route_id' => $item->route_id,
                        'route_name' => implode(" - ", $cities),
                        'route_departure_desc' => $item->route_departure_desc,
                        'actions' => view('components.datatable.actions', [
                        //'actions' => view('components.datatable.actions-block', [
                            'resource' => $this->resource,
                            'id' => $item->route_id,
                            'item_block' => $item->item_block,
                            'show' => false,
                            'edit' => false,
                            'delete' => true,
                            'block' => true
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
            'route.route_id',
            'route.route_name',
            'route.route_departure_desc'
        ];

        $orderColumnIndex = (int) $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'desc');
        $orderColumn = $columns[$orderColumnIndex] ?? 'route.route_id';

        if ($orderColumnIndex === 1 || $orderColumnIndex === 2) {
            $query->orderBy(City::select('city_name')->take(1), $orderDir);
        } else {
            $query->orderBy($orderColumn, $orderDir);
        }

        return $query->offset((int) $request->input('start', 0))
            ->limit((int) $request->input('length', $this->perPage))
            ->get();
    }

    // protected function applyFilters($query, Request $request): void
    // {
    //     if ($request->filled('city_name')) {
    //         $query->where('city_name', 'like', '%' . $request->city_name . '%');
    //     }
    // }

    public function create()
    {
        $cities = City::all();
        return view($this->resource.'.create', ['cities' => $cities, 'resource' => $this->resource]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'routes_id' => 'required',
            'return_routes_id' => 'required',
            'route_total_bus' => 'required|min:0'
        ]);

        DB::beginTransaction();

        try{
            $route = new Route();
            $route->transport_id = 37;
            $route->route_name = $request->routes_id;
            $route->route_departure_desc = $request->route_departure_desc;
            $route->route_total_bus = $request->route_total_bus ?? 0;
            $route->route_online_booking_option = $request->route_online_booking_option ?? 0;
            $route->route_saved_by = 1;
            $route->save();

            $reverse = new Route();
            $reverse->return_route_id = $route->route_id;
            $reverse->transport_id = 37;
            $reverse->route_name = $request->return_routes_id;
            $reverse->route_departure_desc = $request->route_departure_desc;
            $reverse->route_total_bus = $request->route_total_bus ?? 0;
            $reverse->route_online_booking_option = $request->route_online_booking_option ?? 0;
            $reverse->route_saved_by = 1;
            $reverse->save();

            DB::commit();
            return redirect()->route($this->resource.'.index')->with('success', [
                'title' => 'New Route',
                'oldStatus' => null,
                'newStatus' => 'Created Successfully',
            ]);
        } 
        catch (Exception $e){
            DB::rollBack();
            return back()->withInput()->with('error', [
                'title' => 'Creation Failed',
                'oldStatus' => null,
                'newStatus' => 'Failed to create Route. Please try again.'
            ]);
        }
    }

    public function toggle($id){
        $route = Route::findOrFail($id);
        $route->route_block = $route->route_block == 1 ? 0 : 1;
        $route->save();

        return redirect()->route('routes.index')->with('success', [
            'title' => null,
            'oldStatus' => null,
            'newStatus' => 'Route status updated.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Route $route)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Route $route)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Route $route)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        DB::beginTransaction();

        try{

            Route::where('return_route_id', $id)
                ->where('created_at', '>=', Carbon::now()->subHours(72))
                ->delete();


            Route::where('return_route_id', $id)->delete();
            Route::destroy($id);

            DB::commit();
            return redirect()->route($this->resource.'.index')->with('success', [
                'title' => 'Route',
                'oldStatus' => null,
                'newStatus' => 'Deleted Successfully',
            ]);
        } 
        catch (Exception $e){
            DB::rollBack();
            return back()->withInput()->with('error', [
                'title' => 'Route',
                'oldStatus' => null,
                'newStatus' => 'Failed to delete City. Please try again.'
            ]);
        }
    }
}
