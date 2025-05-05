<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface EmployeeRepositoryInterface
{
    /**
     * Get all employees, optionally including soft-deleted ones.
     */
    public function getAll(bool $withTrashed = false): Builder;

    /**
     * Find an employee by ID, optionally including soft-deleted ones.
     */
    public function findById(int $id, bool $withTrashed = false);

    /**
     * Create a new employee.
     */
    public function create(array $data);

    /**
     * Update an existing employee.
     */
    public function update(int $id, array $data): bool;

    /**
     * Soft delete an employee.
     */
    public function softDelete(int $id): bool;

    /**
     * Force delete an employee.
     */
    public function forceDelete(int $id): bool;
}