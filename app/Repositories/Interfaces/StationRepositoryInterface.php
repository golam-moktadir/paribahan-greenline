<?php

namespace App\Repositories\Interfaces;
use Illuminate\Database\Eloquent\Builder;

interface StationRepositoryInterface
{
    public function create(array $data);

    public function getAll(): Builder;

    public function findById(int $id);

    public function update(int $id, array $data);

}
