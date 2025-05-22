<?php

namespace App\Services;

use App\Repositories\Interfaces\OffenceRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Exception;

class OffenceService
{
    protected $offenceRepository;

    public function __construct(OffenceRepositoryInterface $offenceRepository)
    {
        $this->offenceRepository = $offenceRepository;
    }

    /**
     * Get all items, optionally including soft-deleted ones.
     */
    public function getAllItems(bool $withTrashed = false): Builder
    {
        return $this->offenceRepository->getAll($withTrashed);
    }

    /**
     * Get an item by ID, optionally including soft-deleted ones.
     */
    public function getItemById(int $id, bool $withTrashed = false)
    {
        return $this->offenceRepository->findById($id, $withTrashed);
    }

    /**
     * Create a new item with the provided data.
     */
    public function createItem(array $data)
    {
        return $this->offenceRepository->create($data);
    }

    /**
     * Update an existing item with the provided data.
     */
    public function updateItem(int $id, array $data)
    {
        return $this->offenceRepository->update($id, $data);
    }

    /**
     * Delete (soft delete) an item.
     */
    public function deleteItem(int $id): bool
    {
        try {
            return $this->offenceRepository->softDelete($id);
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
            return $this->offenceRepository->forceDelete($id);
        } catch (Exception $e) {
            Log::error('Failed to force delete item: ' . $e->getMessage());
            throw new Exception('Failed to force delete item.');
        }
    }
}