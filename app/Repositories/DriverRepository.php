<?php

namespace App\Repositories;

use App\Models\Driver;
use App\Repositories\Interfaces\DriverRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class DriverRepository implements DriverRepositoryInterface
{
    protected $model;

    public function __construct(Driver $model)
    {
        $this->model = $model;
    }

    /**
     * Get all drivers, optionally including soft-deleted ones.
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
     * Find an driver by ID, optionally including soft-deleted ones.
     */
    public function findById(int $id, bool $withTrashed = false): Driver
    {
        $query = $withTrashed ? $this->model->withTrashed() : $this->model->newQuery();
        return $query->with(['transport', 'department'])->findOrFail($id);
    }

    /**
     * Create a new driver.
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing driver.
     */

    public function update(int $id, array $data): bool
    {
        return $this->model->findOrFail($id)->update($data);
    }

    /**
     * Soft delete an driver.
     */
    public function softDelete(int $id): bool
    {
        $employee = $this->findById($id);
        return (bool) $employee->delete();
    }

    /**
     * Force delete an driver.
     */
    public function forceDelete(int $id): bool
    {
        $employee = $this->findById($id, true);
        return (bool) $employee->forceDelete();
    }
}