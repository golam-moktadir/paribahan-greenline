<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Guide;
use App\Http\Requests\StoreGuideRequest;
use App\Http\Requests\UpdateGuideRequest;
use App\Models\Transport;
use App\Services\GuideService;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\Request;

class GuideController extends Controller
{
    protected $guideService;

    public function __construct(GuideService $guideService)
    {
        $this->guideService = $guideService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $request->ajax() ? $this->handleAjax($request) : view('guides.index');
    }

    protected function handleAjax(Request $request)
    {
        try {
            $query = $this->guideService->getAllItems()
                ->select(
                    'guides.id',
                    'guides.full_name',
                    'guides.id_no',
                    'guides.phone',
                    'guides.status',
                    'guides.joining_date',
                    'department.department_name',
                    'transport.transport_name'
                )
                ->leftJoin('department', 'guides.department_id', '=', 'department.department_id')
                ->leftJoin('transport', 'guides.transport_id', '=', 'transport.transport_id');

            $searchParams = [
                'searchName' => 'guides.full_name',
                'searchIdNo' => 'guides.id_no',
                'searchPhone' => 'guides.phone',
            ];

            foreach ($searchParams as $input => $column) {
                if ($search = trim($request->input($input, ''))) {
                    $query->whereRaw("LOWER($column) LIKE ?", ['%' . strtolower($search) . '%']);
                }
            }

            // status filter
            if ($request->filled('searchStatus')) {
                $query->where('guides.status', $request->input('searchStatus'));
            }

            $columns = [
                'guides.id',
                'guides.full_name',
                'guides.id_no',
                'guides.phone',
                'guides.status',
                'department.department_name',
                'guides.joining_date'
            ];

            // sorting
            $query->orderBy(
                $columns[$request->input('order.0.column', 1)] ?? 'guides.full_name',
                $request->input('order.0.dir', 'asc')
            );

            $total = $this->guideService->getAllItems()->count();
            $filtered = $query->count();

            // pagination
            $guides = $query->offset($request->input('start', 0))
                ->limit($request->input('length', 10))
                ->get();

            return response()->json([
                'draw' => $request->input('draw', 1),
                'recordsTotal' => $total,
                'recordsFiltered' => $filtered,
                'data' => $guides->map(fn($guide) => [
                    'id' => $guide->id,
                    'full_name' => $guide->full_name ?? '',
                    'id_no' => $guide->id_no ?? '',
                    'phone' => $guide->phone ?? '',
                    'status' => Guide::STATUSES[$guide->status] ?? 'Unknown',
                    'department_name' => $guide->department_name ?? '',
                    'joining_date' => $guide->joining_date?->format('d-m-Y') ?? '',
                    'actions' => view('guides.partials.actions', ['guide' => $guide])->render(),
                ])->toArray(),
            ]);
        } catch (\Exception $e) {
            Log::error('Guide AJAX error: ' . $e->getMessage());
            return response()->json([
                'draw' => $request->input('draw', 1),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Failed to load guides.',
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

        return view('guides.create', compact('transports', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuideRequest $request)
    {
        try {
            $itemData = $request->validated();
            $item = $this->guideService->createItem($itemData);

            return redirect()
                ->route('guides.index')
                ->with('success', [
                    'title' => $item->full_name ?? 'New Data',
                    'oldStatus' => null,
                    'newStatus' => 'Created Successfully',
                ]);
        } catch (\Exception $e) {

            Log::error('Data creation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'driver_data' => $request->validated(),
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
    public function show($guide)
    {
        try {
            $guide = $this->guideService->getItemById($guide);
            return view('guides.show', compact('guide'));
        } catch (\Exception $e) {
            return redirect()->route('guides.index')->withErrors(['error' => 'Item not found.']);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($guide)
    {
        $guide = $this->guideService->getItemById($guide);

        return view('guides.edit', [
            'guide' => $guide,
            'transports' => Transport::all(),
            'departments' => Department::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuideRequest $request, $guide)
    {
        try {
            $guide = $this->guideService->updateItem($guide, $request->validated());

            return redirect()->route('guides.index')->with('success', [
                'title' => $guide->full_name ?? 'Updated Item',
                'oldStatus' => null,
                'newStatus' => 'Item updated successfully!',
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update item: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($guide)
    {
        try {
            $this->guideService->deleteItem($guide);

            return redirect()->route('guides.index')->with('success', [
                'title' => $guide->full_name ?? 'Guide',
                'oldStatus' => 'Active',
                'newStatus' => 'Deleted'
            ]);
        } catch (Exception $e) {
            return redirect()->route('guides.index')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function forceDelete($id)
    {
        try {
            $this->guideService->forceDeleteItem($id);

            return redirect()->route('guides.index')->with('success', [
                'title' => 'Guide',
                'oldStatus' => 'Soft Deleted',
                'newStatus' => 'Permanently Deleted'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('guides.index')->withErrors(['error' => 'Failed to force delete item.']);
        }
    }
}
