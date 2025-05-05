<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface DriverRepositoryInterface
{
    /**
     * Get all drivers, optionally including soft-deleted ones.
     */
    public function getAll(bool $withTrashed = false): Builder;

    /**
     * Find an driver by ID, optionally including soft-deleted ones.
     */
    public function findById(int $id, bool $withTrashed = false);

    /**
     * Create a new driver.
     */
    public function create(array $data);

    /**
     * Update an existing driver.
     */
    public function update(int $id, array $data): bool;

    /**
     * Soft delete an driver.
     */
    public function softDelete(int $id): bool;

    /**
     * Force delete an driver.
     */
    public function forceDelete(int $id): bool;
}
