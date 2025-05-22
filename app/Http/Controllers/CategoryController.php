<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;


class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $request->ajax() ? $this->handleAjax($request) : view('categories.index');
    }

    protected function handleAjax(Request $request)
    {
        try {
            $query = $this->categoryService->getAllCategories()
                ->select(
                    'categories.category_id',
                    'categories.category_name',
                );

            $searchParams = [
                'searchName' => 'categories.category_name',
            ];

            foreach ($searchParams as $input => $column) {
                if ($search = trim($request->input($input, ''))) {
                    $query->whereRaw("LOWER($column) LIKE ?", ['%' . strtolower($search) . '%']);
                }
            }

            $columns = [
                'categories.category_id',
                'categories.category_name',
            ];

            // sorting
            $query->orderBy(
                $columns[$request->input('order.0.column', 1)] ?? 'categories.category_name',
                $request->input('order.0.dir', 'asc')
            );

            $total = $this->categoryService->getAllCategories()->count();
            $filtered = $query->count();

            // pagination
            $categories = $query->offset($request->input('start', 0))
                ->limit($request->input('length', 10))
                ->get();

            return response()->json([
                'draw' => $request->input('draw', 1),
                'recordsTotal' => $total,
                'recordsFiltered' => $filtered,
                'data' => $categories->map(fn($category) => [
                    'category_id' => $category->category_id,
                    'category_name' => $category->category_name ?? '',
                    'actions' => view('categories.partials.actions', ['category' => $category])->render(),
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
    public function store(StoreCategoryRequest $request)
    {
        try {
            $itemValidatedData = $request->validated();
            $item = $this->categoryService->createDriver($itemValidatedData);

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
            $item = $this->categoryService->getDriverById($driver)->load(['transport', 'department', 'creator']);
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
        $item = $this->categoryService->getDriverById($driver);

        return view('drivers.edit', [
            'item' => $item,
            'transports' => Transport::all(),
            'departments' => Department::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $driver)
    {
        try {
            $item = $this->categoryService->updateDriver($driver, $request->validated());

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
            $this->categoryService->deleteDriver($driver);

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
            $this->categoryService->forceDeleteDriver($id);

            return redirect()->route('drivers.index')->with('success', [
                'title' => 'Item',
                'oldStatus' => 'Soft Deleted',
                'newStatus' => 'Permanently Deleted'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('drivers.index')->withErrors(['error' => 'Failed to force delete item.']);
        }
    }



}
