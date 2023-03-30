<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected Builder|Model $query;
    public function __construct()
    {
        $this->query = (new $this->model);
    }

    public function findById(int $id)
    {
        return $this->query->findOrFail($id);
    }

    public function getAll()
    {
        return $this->query->latest()->get();
    }

    public function destroy(int $id): bool
    {
        return $this->query->find($id)->delete();
    }

    public function create(array $details)
    {
        return $this->query->create($details);
    }

    public function update(int $id, array $newDetails)
    {
        $model = $this->query->find($id);
        return tap($model)->update($newDetails);
    }
}