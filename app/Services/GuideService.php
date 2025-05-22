<?php

namespace App\Services;

use App\Repositories\Interfaces\GuideRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Exception;

class GuideService
{
    protected $guideRepository;

    public function __construct(GuideRepositoryInterface $guideRepository)
    {
        $this->guideRepository = $guideRepository;
    }

    /**
     * Get all items, optionally including soft-deleted ones.
     */
    public function getAllItems(bool $withTrashed = false): Builder
    {
        return $this->guideRepository->getAll($withTrashed);
    }

    /**
     * Get an item by ID, optionally including soft-deleted ones.
     */
    public function getItemById(int $id, bool $withTrashed = false)
    {
        return $this->guideRepository->findById($id, $withTrashed);
    }

    /**
     * Create a new item with the provided data.
     */
    public function createItem(array $data)
    {
        $defaults = [
            'created_by' => Auth::id() ?? 1,
        ];

        return $this->guideRepository->create(array_merge($defaults, $data));
    }

    /**
     * Update an existing item with the provided data.
     */
    public function updateItem(int $id, array $data)
    {
        return $this->guideRepository->update($id, $data);
    }

    /**
     * Delete (soft delete) an item.
     */
    public function deleteItem(int $id): bool
    {
        try {
            return $this->guideRepository->softDelete($id);
        } catch (Exception $e) {
            Log::error('Failed to soft delete item: ' . $e->getMessage());
            throw new Exception('Failed to delete item.');
        }
    }

    /**
     * Force delete (permanent delete) an item.
     */
    public function forceDeleteItem(int $id): bool
    {
        try {
            return $this->guideRepository->forceDelete($id);
        } catch (Exception $e) {
            Log::error('Failed to force delete item: ' . $e->getMessage());
            throw new Exception('Failed to force delete item.');
        }
    }
}