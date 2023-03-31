<?php

namespace App\Interface\Repository;

interface BaseRepositoryInterface
{
    public function findById(int $id);
}
