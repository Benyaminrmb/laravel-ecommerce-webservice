<?php

namespace App\Http\Controllers\General;

use App\Interface\CategoryRepositoryInterface;

class CategoryController
{
    private CategoryRepositoryInterface $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll()
    {
        return $this->categoryRepository->getAll();
    }
}
