<?php

namespace App\Repositories;

use App\Models\Guide;
use App\Repositories\Interfaces\GuideRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class GuideRepository implements GuideRepositoryInterface
{
    protected $model;

    public function __construct(Guide $model)
    {
        $this->model = $model;
    }

    /**
     * Get all items, optionally including soft-deleted ones.
     */
    public function getAll(bool $withTrashed = false): Builder
    {
        $query = $this->model->newQuery()->with(['transport', 'department']);

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query;
    }

    /**
     * Find an item by ID, optionally including soft-deleted ones.
     */
    public function findById(int $id, bool $withTrashed = false): Guide
    {
        $query = $withTrashed ? $this->model->withTrashed() : $this->model->newQuery();
        return $query->with(['transport', 'department'])->findOrFail($id);
    }

    /**
     * Create a new item.
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing item.
     */

    public function update(int $id, array $data): bool
    {
        return $this->model->findOrFail($id)->update($data);
    }

    /**
     * Soft delete an item.
     */
    public function softDelete(int $id): bool
    {
        $item = $this->findById($id);
        return (bool) $item->delete();
    }

    /**
     * Force delete an item.
     */
    public function forceDelete(int $id): bool
    {
        $item = $this->findById($id, true);
        return (bool) $item->forceDelete();
    }
}