<?php

namespace App\Interface\Repository;

interface CategoryRepositoryInterface
{
    public function getAll();

    public function findById(int $id);

    public function trash(int $id);

    public function restore(int $id);

    public function create(array $details);

    public function update(int $id, array $newDetails);
}
