<?php

namespace App\Interface\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

interface BaseRepositoryInterface
{
    public function getAll();

    public function trash(Builder|Model $model);

    public function restore(Builder|Model $model);

    public function delete(Model $model);

    public function create(array $data);

    public function update(Builder|Model $model, array $data);
}
