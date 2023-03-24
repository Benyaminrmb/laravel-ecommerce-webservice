<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\CategoryRequest;
use App\Interface\CategoryRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories=$this->categoryRepository->getAll();
        return $this->jsonResponse(data:$categories);
    }

    public function store(CategoryRequest $request)
    {
        $newCategory=[
            'name'=>$request->get('name')
        ];
        $category=$this->categoryRepository->create($newCategory);
        return $this->jsonResponse(data:$category,statusCode: Response::HTTP_CREATED);
    }

}
