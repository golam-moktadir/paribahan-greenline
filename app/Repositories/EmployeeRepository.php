<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    protected $model;

    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    /**
     * Get all employees, optionally including soft-deleted ones.
     */
    public function getAll(bool $withTrashed = false): Builder
    {
        $query = $this->model->newQuery()->with(['transport', 'department', 'workGroup']);

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query;
    }

    /**
     * Find an employee by ID, optionally including soft-deleted ones.
     */
    public function findById(int $id, bool $withTrashed = false): Employee
    {
        $query = $withTrashed ? $this->model->withTrashed() : $this->model->newQuery();
        return $query->with(['transport', 'department', 'workGroup'])->findOrFail($id);
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