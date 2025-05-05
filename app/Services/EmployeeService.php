<?php

namespace App\Services;

use App\Models\Member;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Exception;

class EmployeeService
{
    protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Get all employees, optionally including soft-deleted ones.
     */
    public function getAllEmployees(bool $withTrashed = false): Builder
    {
        return $this->employeeRepository->getAll($withTrashed);
    }

    /**
     * Get an employee by ID, optionally including soft-deleted ones.
     */
    public function getEmployeeById(int $id, bool $withTrashed = false)
    {
        return $this->employeeRepository->findById($id, $withTrashed);
    }



    /**
     * Create a new employee with the provided data.
     */
    public function createEmployee(array $data)
    {
        $defaults = [
            // 'employee_id' => null,
            'employee_saved_by' => Auth::id() ?? 1,
            'employee_save_status' => 1,
            'employee_activation_id' => (string) Str::uuid(),
        ];

        return $this->employeeRepository->create(array_merge($defaults, $data));
    }

    /**
     * Update an existing employee with the provided data.
     */
    public function updateEmployee(int $id, array $data)
    {
        // if (!empty($data['employee_new_password'])) {
        //     $data['employee_new_password'] = Hash::make($data['employee_new_password']);
        // }

        // Handle avatar upload
        // if (isset($data['avatar']) && $data['avatar'] instanceof \Illuminate\Http\UploadedFile) {
        //     $path = $data['avatar']->store('avatars', 'public');
        //     $data['avatar'] = $path;
        // } else {
        //     unset($data['avatar']); 
        // }

        return $this->employeeRepository->update($id, $data);
    }

    /**
     * Delete (soft delete) an employee.
     */
    public function deleteEmployee(int $id): bool
    {
        try {
            return $this->employeeRepository->softDelete($id);
        } catch (Exception $e) {
            Log::error('Failed to soft delete employee: ' . $e->getMessage());
            throw new Exception('Failed to delete employee.');
        }
    }


    /**
     * Force delete (permanent delete) an employee.
     */
    public function forceDeleteEmployee(int $id): bool
    {
        try {
            return $this->employeeRepository->forceDelete($id);
        } catch (Exception $e) {
            Log::error('Failed to force delete employee: ' . $e->getMessage());
            throw new Exception('Failed to force delete employee.');
        }
    }
}