<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Services\CityService;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CityController extends Controller
{

    protected $service;
    protected $resource = 'cities';
    protected $perPage = 10;

    public function __construct(CityService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): View|JsonResponse
    {
        return view($this->resource.".index", ['resource' => $this->resource]);
    }

    public function getAllData(Request $request): JsonResponse
    {
        
        try {
            $query = City::query();
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
                        'city_id' => $item->city_id,
                        'city_name' => $item->city_name,
                        'city_code' => $item->city_code,
                        'city_image_name' => $item->city_image_name,
                        'actions' => view('components.datatable.actions', [
                            'resource' => $this->resource,
                            'id' => $item->city_id,
                            'show' => false,
                            'edit' => true,
                            'delete' => true,
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
            'city.city_id',
            'city.city_name',
            'city.city_code',
            'city.city_image_name'
        ];

        $orderColumnIndex = (int) $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'desc');
        $orderColumn = $columns[$orderColumnIndex] ?? 'city.city_id';

        if ($orderColumnIndex === 1 || $orderColumnIndex === 2) {
            $query->orderBy(City::select('city_name')->take(1), $orderDir);
        } else {
            $query->orderBy($orderColumn, $orderDir);
        }

        return $query->offset((int) $request->input('start', 0))
            ->limit((int) $request->input('length', $this->perPage))
            ->get();
    }

    protected function applyFilters($query, Request $request): void
    {
        if ($request->filled('city_name')) {
            $query->where('city_name', 'like', '%' . $request->city_name . '%');
        }
    }

    public function create()
    {
        return view($this->resource.'.create', ['resource' => $this->resource]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'city_name' => 'required|string|unique:city',
            'city_code' => 'required|string|unique:city|max:4'
        ]);

        DB::beginTransaction();

        try{
            $city = new City();
            $city->city_name = $request->city_name;
            $city->city_code = strtoupper($request->city_code);
            $city->city_image_name = '';
            $city->save();

            DB::commit();
            return redirect()->route($this->resource.'.index')->with('success', [
                'title' => 'New City',
                'oldStatus' => null,
                'newStatus' => 'Created Successfully',
            ]);
        } 
        catch (Exception $e){
            DB::rollBack();
            return back()->withInput()->with('error', [
                'title' => 'Creation Failed',
                'oldStatus' => null,
                'newStatus' => 'Failed to create City. Please try again.'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $single = City::findOrFail($id);
        return view($this->resource.'.edit', ['single' => $single, 'resource' => $this->resource]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'city_name' => ['required', 'string', Rule::unique("city")->ignore($id, 'city_id')],
            'city_code' => ['required', 'string', Rule::unique("city")->ignore($id, 'city_id'), 'max:4']
        ]);
        DB::beginTransaction();

        try{
            $city = City::find($id);
            $city->city_name = $request->city_name;
            $city->city_code = strtoupper($request->city_code);
            $city->city_image_name = '';
            $city->save();

            DB::commit();
            return redirect()->route($this->resource.'.index')->with('success', [
                'title' => 'New City',
                'oldStatus' => null,
                'newStatus' => 'Created Successfully',
            ]);
        } 
        catch (Exception $e){
            DB::rollBack();
            return back()->withInput()->with('error', [
                'title' => 'Creation Failed',
                'oldStatus' => null,
                'newStatus' => 'Failed to create City. Please try again.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try{
            $city = City::find($id);
            $city->delete();

            DB::commit();
            return redirect()->route($this->resource.'.index')->with('success', [
                'title' => 'City',
                'oldStatus' => null,
                'newStatus' => 'Deleted Successfully',
            ]);
        } 
        catch (Exception $e){
            DB::rollBack();
            return back()->withInput()->with('error', [
                'title' => 'Creation Failed',
                'oldStatus' => null,
                'newStatus' => 'Failed to delete City. Please try again.'
            ]);
        }
    }
}
