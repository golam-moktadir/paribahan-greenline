<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface CategoryRepositoryInterface
{
    /**
     * Get all items, optionally including soft-deleted ones.
     */
    public function getAll(bool $withTrashed = false): Builder;

    /**
     * Find an item by ID, optionally including soft-deleted ones.
     */
    public function findById(int $id, bool $withTrashed = false);

    /**
     * Create a new item.
     */
    public function create(array $data);

    /**
     * Update an existing item.
     */
    public function update(int $id, array $data): bool;

    /**
     * Soft delete an item.
     */
    public function softDelete(int $id): bool;

    /**
     * Force delete an item.
     */
    public function forceDelete(int $id): bool;
}
