<?php

namespace App\Services;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Exception;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get all Categories, optionally including soft-deleted ones.
     */
    public function getAllCategories(bool $withTrashed = false): Builder
    {
        return $this->categoryRepository->getAll($withTrashed);
    }

    /**
     * Get an Category by ID, optionally including soft-deleted ones.
     */
    public function getCategoryById(int $id, bool $withTrashed = false)
    {
        return $this->categoryRepository->findById($id, $withTrashed);
    }


    /**
     * Create a new Category with the provided data.
     */
    public function createCategory(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    /**
     * Update an existing Category with the provided data.
     */
    public function updateCategory(int $id, array $data)
    {
        return $this->categoryRepository->update($id, $data);
    }

    /**
     * Delete (soft delete) an Category.
     */
    public function deleteCategory(int $id): bool
    {
        try {
            return $this->categoryRepository->softDelete($id);
        } catch (Exception $e) {
            Log::error('Failed to soft delete category: ' . $e->getMessage());
            throw new Exception('Failed to delete category.');
        }
    }

    /**
     * Force delete (permanent delete) an Category.
     */
    public function forceDeleteCategory(int $id): bool
    {
        try {
            return $this->categoryRepository->forceDelete($id);
        } catch (Exception $e) {
            Log::error('Failed to force delete category: ' . $e->getMessage());
            throw new Exception('Failed to force delete category.');
        }
    }
}