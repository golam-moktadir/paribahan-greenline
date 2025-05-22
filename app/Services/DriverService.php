<?php

namespace App\Services;

use App\Repositories\Interfaces\DriverRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Exception;

class DriverService
{
    protected $driverRepository;

    public function __construct(DriverRepositoryInterface $driverRepository)
    {
        $this->driverRepository = $driverRepository;
    }

    /**
     * Get all drivers, optionally including soft-deleted ones.
     */
    public function getAllDrivers(bool $withTrashed = false): Builder
    {
        return $this->driverRepository->getAll($withTrashed);
    }

    /**
     * Get an driver by ID, optionally including soft-deleted ones.
     */
    public function getDriverById(int $id, bool $withTrashed = false)
    {
        return $this->driverRepository->findById($id, $withTrashed);
    }


    /**
     * Create a new driver with the provided data.
     */
    public function createDriver(array $data)
    {
        $defaults = [
            'created_by' => Auth::id() ?? 1,
        ];

        return $this->driverRepository->create(array_merge($defaults, $data));
    }

    /**
     * Update an existing driver with the provided data.
     */
    public function updateDriver(int $id, array $data)
    {
        return $this->driverRepository->update($id, $data);
    }

    /**
     * Delete (soft delete) an driver.
     */
    public function deleteDriver(int $id): bool
    {
        try {
            return $this->driverRepository->softDelete($id);
        } catch (Exception $e) {
            Log::error('Failed to soft delete driver: ' . $e->getMessage());
            throw new Exception('Failed to delete driver.');
        }
    }

    /**
     * Force delete (permanent delete) an driver.
     */
    public function forceDeleteDriver(int $id): bool
    {
        try {
            return $this->driverRepository->forceDelete($id);
        } catch (Exception $e) {
            Log::error('Failed to force delete driver: ' . $e->getMessage());
            throw new Exception('Failed to force delete driver.');
        }
    }
}