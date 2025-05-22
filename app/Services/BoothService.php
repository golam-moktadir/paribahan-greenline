<?php

namespace App\Services;

use App\Repositories\Interfaces\BoothRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Exception;

class BoothService
{
    protected $boothRepository;

    public function __construct(BoothRepositoryInterface $boothRepository)
    {
        $this->boothRepository = $boothRepository;
    }

    /**
     * Get all Booths, optionally including soft-deleted ones.
     */
    public function getAllItems(): Builder
    {
        return $this->boothRepository->getAll();
    }

    /**
     * Get an booth by ID, optionally including soft-deleted ones.
     */
    public function getItemById(int $id)
    {
        return $this->boothRepository->findById($id);
    }

    /**
     * Create a new booth with the provided data.
     */
    public function createBooth(array $data)
    {
        return $this->boothRepository->create($data);
    }

    /**
     * Update an existing booth with the provided data.
     */
    public function updateItem(int $id, array $data)
    {
        return $this->boothRepository->update($id, $data);
    }

    /**
     * Delete (soft delete) an booth.
     */
    public function deleteDriver(int $id): bool
    {
        try {
            return $this->boothRepository->softDelete($id);
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
            return $this->boothRepository->forceDelete($id);
        } catch (Exception $e) {
            Log::error('Failed to force delete driver: ' . $e->getMessage());
            throw new Exception('Failed to force delete driver.');
        }
    }
}