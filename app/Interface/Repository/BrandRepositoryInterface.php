<?php

namespace App\Interface\Repository;

interface BrandRepositoryInterface extends BaseRepositoryInterface
{
    public function getAll();

    public function trash(int $id);

    public function restore(int $id);

    public function create(array $details);

    public function update(int $id, array $newDetails);
}
