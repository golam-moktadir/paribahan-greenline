<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreOffenceRequest, UpdateOffenceRequest};
use App\Models\Driver;
use App\Models\Offence;
use App\Services\OffenceService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\{JsonResponse, RedirectResponse, Request};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Exception;

/**
 * Controller for managing offence records with CRUD and DataTables support.
 */
class OffenceController extends Controller
{
    /**
     * The offence service instance.
     *
     * @var OffenceService
     */
    protected $service;

    /**
     * Resource name for routes and views.
     *
     * @var string
     */
    protected $resource = 'offences';

    /**
     * Feature name used in messages and logs.
     *
     * @var string
     */
    protected string $featureName = 'Offence';

    /**
     * Feature plural name used in view pages.
     *
     * @var string
     */
    protected string $featurePluralName = 'Offences';


    /**
     * This is useful when referring to the model in a case-insensitive way.
     *
     * @var string
     */
    protected string $modelVariable = 'offence';

    /**
     * Default items per page for pagination.
     *
     * @var int
     */
    protected $perPage = 10;

    /**
     * Initialize controller with service dependency.
     *
     * @param OffenceService $service
     */
    public function __construct(OffenceService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource or handle DataTables AJAX request.
     *
     * @param Request $request
     * @return View|JsonResponse
     */
    public function index(Request $request): View|JsonResponse
    {
        return $request->ajax()
            ? $this->handleDataTableRequest($request)
            : view("{$this->resource}.index", [
                'featureName' => $this->featurePluralName,
                'resource' => $this->resource,
            ]);
    }

    /**
     * Show form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view("{$this->resource}.create", [
            'drivers' => Driver::select(['id', 'full_name', 'id_no', 'driving_license_no'])
                ->orderBy('full_name')
                ->get(),
            'featureName' => $this->featureName,
        ]);
    }

    /**
     * Store a new resource.
     *
     * @param StoreOffenceRequest $request
     * @return RedirectResponse
     */
    public function store(StoreOffenceRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();
            $attachmentFiles = $validated['complainant_attachments'] ?? [];
            unset($validated['complainant_attachments']);

            $item = DB::transaction(function () use ($validated, $attachmentFiles) {
                $item = $this->service->createItem($validated);
                // dd($item);

                foreach ($attachmentFiles as $filePath) {
                    $item->attachments()->create([
                        'path' => $filePath,
                        'original_name' => basename($filePath),
                    ]);
                }
                return $item;

            });

            $title = sprintf(
                '%s (ID No: %s, Date: %s)',
                $item->driver->full_name ?? 'Unknown Driver',
                $item->driver->id_no ?? 'N/A',
                $item->occurrence_date?->format('Y-m-d') ?? 'N/A'
            );

            return $this->redirectWithSuccess(
                $title ?? 'New Data',
                null,
                "{$this->featureName} created successfully."
            );

        } catch (Exception $e) {
            Log::error("{$this->featureName} creation failed: {$e->getMessage()}", [
                'input' => $request->except('complainant_attachment'),
            ]);

            return $this->redirectWithError(
                "Creation Failed",
                null,
                "Failed to create {$this->featureName}: {$e->getMessage()}"
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return View|RedirectResponse
     */
    public function show(int $id): View|RedirectResponse
    {
        try {
            $item = $this->service->getItemById($id)->load(['driver', 'attachments']);

            return view("{$this->resource}.show", [
                $this->modelVariable => $item,
                'featureName' => $this->featurePluralName,
            ]);
        } catch (Exception $e) {
            Log::warning("{$this->featureName} #{$id} not found: {$e->getMessage()}");

            return $this->redirectWithError(
                "Failed",
                null,
                "{$this->featureName} not found: {$e->getMessage()}"
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View|RedirectResponse
    {
        try {
            return view("{$this->resource}.edit", [
                $this->modelVariable => $this->service->getItemById($id),
                'drivers' => Driver::select(['id', 'full_name', 'id_no', 'driving_license_no'])
                    ->orderBy('full_name')
                    ->get(),
                'featureName' => $this->featureName,
            ]);
        } catch (Exception $e) {
            Log::warning("{$this->featureName} #{$id} not found: {$e->getMessage()}");

            return $this->redirectWithError(
                "Failed",
                null,
                "{$this->featureName} not found: {$e->getMessage()}"
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOffenceRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UpdateOffenceRequest $request, int $id): RedirectResponse
    {
        try {
            $item = $this->service->updateItem($id, $request->validated());

            return $this->redirectWithSuccess(
                $id . '# Data updated',
                null,
                "{$this->featureName} updated successfully."
            );

        } catch (Exception $e) {
            Log::error("{$this->featureName} #{$id} update failed: {$e->getMessage()}");

            return $this->redirectWithError(
                "Failed to update",
                null,
                "Failed to update {$this->featureName}: {$e->getMessage()}"
            );
        }
    }

    /**
     * Soft delete the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $item = $this->service->deleteItem($id);

            return $this->redirectWithSuccess(
                "Data deleted",
                null,
                "{$this->featureName} deleted successfully."
            );

        } catch (Exception $e) {
            Log::error("{$this->featureName} #{$id} deletion failed: {$e->getMessage()}");

            return $this->redirectWithError(
                "Failed to delete",
                null,
                "Failed to delete {$this->featureName}: {$e->getMessage()}"
            );
        }
    }

    /**
     * force or permanently delete the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function forceDelete(int $id): RedirectResponse
    {
        try {
            $item = $this->service->forceDeleteItem($id);

            return $this->redirectWithSuccess(
                "Data permanently deleted",
                null,
                "{$this->featureName} permanently deleted successfully."
            );

        } catch (Exception $e) {
            Log::error("{$this->featureName} #{$id} permanent deletion failed: {$e->getMessage()}");

            return $this->redirectWithError(
                "Failed to permanently delete",
                null,
                "Failed to permanently delete {$this->featureName}: {$e->getMessage()}"
            );

        }
    }
    /**
     * permanently delete the specified attachment from a offence
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function attachmentDelete($offenceId, $attachmentId): RedirectResponse
    {


        try {
            $offence = Offence::findOrFail($offenceId);
            $attachment = $offence->attachments()->findOrFail($attachmentId);

            if (file_exists(public_path($attachment->path))) {
                unlink(public_path($attachment->path));
            }

            $attachment->delete();

            return $this->redirectWithSuccess(
                "Data permanently deleted",
                null,
                "{$this->featureName} permanently deleted successfully."
            );

        } catch (Exception $e) {
            Log::error("Attachment delete failed: {$e->getMessage()}", [
                'offence_id' => $offenceId,
                'attachment_id' => $attachmentId,
            ]);

            // Log::error("{$this->featureName} #{$attachmentId} permanent deletion failed: {$e->getMessage()}");

            return $this->redirectWithError(
                "Failed to permanently delete",
                null,
                "Failed to permanently delete {$this->featureName}: {$e->getMessage()}"
            );

        }
    }
    /**
     * Handle DataTables AJAX request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    protected function handleDataTableRequest(Request $request): JsonResponse
    {
        try {
            // Log incoming request parameters
            // Log::debug("{$this->featureName} DataTable request received", [
            //     'params' => $request->all(),
            //     // 'user_id' => auth()->id(),
            // ]);

            // Initialize query with eager-loaded driver relationship
            $query = $this->service->getAllItems()->with('driver');

            // Log::debug("{$this->featureName} Initial query", [
            //     'sql' => $query->toSql(),
            //     'bindings' => $query->getBindings(),
            // ]);

            // Apply filters
            $this->applyFilters($query, $request);

            // Total number of records (unfiltered)
            $total = $this->service->getAllItems()->count();

            // Filtered number of records
            $filtered = $query->count();

            // Apply pagination and sorting
            $results = $this->applyPagination($query, $request);

            // Prepare JSON response
            $response = [
                'draw' => (int) $request->input('draw', 1),
                'recordsTotal' => $total,
                'recordsFiltered' => $filtered,
                'data' => $results->map(function ($item) {
                    $occurrence_date = $item->occurrence_date instanceof \DateTime
                        ? $item->occurrence_date->format('Y-m-d')
                        : ($item->occurrence_date ?? 'N/A');
                    $description = Str::limit($item->description ?? 'N/A', 300);

                    return [
                        'id' => $item->id,
                        'driver_id_no' => $item->driver ? $item->driver->id_no : 'N/A',
                        'driver_full_name' => $item->driver ? $item->driver->full_name : 'N/A',
                        'occurrence_date' => $occurrence_date,
                        'offence_type' => $item->offence_type ?? 'N/A',
                        'complainant_phone' => $item->complainant_phone ?? 'N/A',
                        'description' => $description,
                        'actions' => view('components.datatable.actions', [
                            'resource' => $this->resource,
                            'id' => $item->id,
                            'show' => true,
                            'edit' => true,
                            'delete' => true,
                        ])->render(),
                    ];
                })->toArray()
            ];

            // Log::debug("{$this->featureName} JSON response prepared", [
            //     'draw' => $response['draw'],
            //     'recordsTotal' => $response['recordsTotal'],
            //     'recordsFiltered' => $response['recordsFiltered'],
            //     'data_count' => count($response['data']),
            // ]);

            return response()->json($response);

        } catch (Exception $e) {
            Log::error("{$this->featureName} data table error: {$e->getMessage()}", [
                'request' => $request->all(),
                // 'user_id' => auth()->id(),
                'stack' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'draw' => (int) $request->input('draw', 1),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => "Failed to load {$this->featureName} data.",
            ], 500);
        }
    }

    /**
     * Apply filters to the DataTable query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Request $request
     * @return void
     */
    protected function applyFilters($query, Request $request): void
    {
        // Apply driver-related filter using whereHas
        if ($searchIdNo = trim($request->input('searchIdNo'))) {
            $query->whereHas('driver', function ($q) use ($searchIdNo) {
                $q->whereRaw('LOWER(id_no) LIKE ?', ['%' . strtolower($searchIdNo) . '%']);
            });
        }

        // Apply offence type filter
        if ($request->filled('searchStatus')) {
            $query->where('offence_type', $request->input('searchStatus'));
        }

        // Apply date range filter
        if ($request->filled(['startDate', 'endDate'])) {
            $query->whereBetween('occurrence_date', [
                $request->input('startDate'),
                $request->input('endDate'),
            ]);
        }
    }

    /**
     * Apply pagination and sorting to the DataTable query.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function applyPagination($query, Request $request)
    {
        // Define sortable columns (only offences table columns)
        $columns = [
            'offences.id',
            'offences.driver_id', // Proxy for driver_id_no
            'offences.driver_id', // Proxy for driver_full_name
            'offences.occurrence_date',
            'offences.offence_type',
            'offences.complainant_phone',
            'offences.description',
        ];

        // Determine sorting column and direction
        $orderColumnIndex = (int) $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'desc');
        $orderColumn = $columns[$orderColumnIndex] ?? 'offences.id';

        // Handle driver-related sorting (driver_id, full_name)
        if ($orderColumnIndex === 1 || $orderColumnIndex === 2) {
            // Sort by driver full_name or id_no via subquery
            $query->orderBy(Driver::select('id_no')
                ->whereColumn('drivers.id', 'offences.driver_id')
                ->take(1), $orderDir);
        } else {
            $query->orderBy($orderColumn, $orderDir);
        }

        // Apply pagination
        return $query->offset((int) $request->input('start', 0))
            ->limit((int) $request->input('length', $this->perPage))
            ->get();
    }

    /**
     * Redirect with success message.
     *
     * @param string $title
     * @param string $oldStatus
     *  @param string $newStatus
     * @return RedirectResponse
     */
    protected function redirectWithSuccess(string $title, ?string $oldStatus, string $newStatus): RedirectResponse
    {
        return redirect()
            ->route("{$this->resource}.index")
            ->with('success', [
                'title' => $title,
                'oldStatus' => $oldStatus,
                'newStatus' => $newStatus,
            ]);
    }


    /**
     * Redirect to the index page with an error message.
     *
     * @param string $message The error message content.
     * @return RedirectResponse The redirect response.
     */
    protected function redirectWithError(string $title, ?string $oldStatus, string $newStatus): RedirectResponse
    {
        return redirect()
            ->route("{$this->resource}.index")
            ->with('error', [
                'title' => $title,
                'oldStatus' => $oldStatus,
                'newStatus' => $newStatus,
            ]);
    }
}