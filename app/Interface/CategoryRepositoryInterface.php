<?php

namespace App\Interface;

interface CategoryRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function delete($id);
    public function create(array $details);
    public function update($id, array $newDetails);
}
