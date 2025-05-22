<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * Get all items, optionally including soft-deleted ones.
     */
    public function getAll(bool $withTrashed = false): Builder
    {
        $query = $this->model->newQuery();

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query;
    }

    /**
     * Find an item by ID, optionally including soft-deleted ones.
     */
    public function findById(int $id, bool $withTrashed = false): Category
    {
        $query = $withTrashed ? $this->model->withTrashed() : $this->model->newQuery();
        return $query->findOrFail($id);
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