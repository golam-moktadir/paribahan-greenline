<?php

namespace App\Repositories;

use App\Models\Booth;
use App\Repositories\Interfaces\BoothRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class BoothRepository implements BoothRepositoryInterface
{

    protected $model;

    public function __construct(Booth $model)
    {
        $this->model = $model;
    }

    /**
     * Get all Booths, optionally including soft-deleted ones.
     */
    public function getAll(): Builder
    {
        $query = $this->model->newQuery()->with(['station.city']);
        return $query;
    }

    /**
     * Find an Booth by ID, optionally including soft-deleted ones.
     */
    public function findById(int $id): Booth
    {
        $query = $this->model->newQuery()->with(['station.city', 'employee'])->findOrFail($id);
        return $query;
    }

    /**
     * Create a new employee.
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }


    /**
     * Update an existing employee.
     */

    public function update(int $id, array $data): bool
    {
        return $this->model->findOrFail($id)->update($data);
    }

    /**
     * Soft delete an employee.
     */
    public function softDelete(int $id): bool
    {
        $employee = $this->findById($id);
        return (bool) $employee->delete();
    }

    /**
     * Force delete an employee.
     */
    public function forceDelete(int $id): bool
    {
        $employee = $this->findById($id, true);
        return (bool) $employee->forceDelete();
    }
}