<?php

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Interface\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRepository extends Controller implements BaseRepositoryInterface
{
    protected Builder|Model $query;

    public function __construct()
    {
        if (!empty($this->model)) {
            $this->query = (new $this->model);
        }
    }

    public function getAll()
    {
        return $this->query->latest()->get();
    }

    public function destroy(Builder|Model $model): bool
    {
        return $model->delete();
    }

    public function create(array $data)
    {
        return $this->query->create($data);
    }

    public function update(Builder|Model $model, array $data)
    {
        return tap($model)->update($data);
    }

    public function trash(Builder|Model $model): bool
    {
        return $model->delete();
    }

    public function delete(Model $model): ?bool
    {
        return $model->forceDelete();
    }

    public function restore(Builder|Model $model): bool
    {
        return $model->restore();
    }


}
