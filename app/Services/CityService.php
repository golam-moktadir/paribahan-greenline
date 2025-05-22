<?php

namespace App\Services;

use App\Repositories\Interfaces\CityRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Exception;

class CityService
{
    protected $repository;

    public function __construct(CityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllItems(): Builder
    {
        return $this->repository->getAll();
    }

    public function getItemById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function createBooth(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateItem(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteDriver(int $id): bool
    {
        try {
            return $this->repository->softDelete($id);
        } catch (Exception $e) {
            Log::error('Failed to soft delete driver: ' . $e->getMessage());
            throw new Exception('Failed to delete driver.');
        }
    }

    public function forceDeleteDriver(int $id): bool
    {
        try {
            return $this->repository->forceDelete($id);
        } catch (Exception $e) {
            Log::error('Failed to force delete driver: ' . $e->getMessage());
            throw new Exception('Failed to force delete driver.');
        }
    }
}