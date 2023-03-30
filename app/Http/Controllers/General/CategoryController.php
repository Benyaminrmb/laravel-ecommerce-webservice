<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Interface\Repository\CategoryRepositoryInterface;
use App\Models\Category;
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
        $categories = $this->categoryRepository->getAll();
        return $this->jsonResponse(data: CategoryResource::collection($categories));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $category = $this->categoryRepository->create($data);

        return $this->jsonResponse(data: CategoryResource::make($category), statusCode: Response::HTTP_CREATED);
    }

    public function update(CategoryRequest $request, $id)
    {
        $data = $request->validated();
        $category = $this->categoryRepository->update($id, $data);
        return $this->jsonResponse(data: $category, statusCode: Response::HTTP_OK);
    }

    public function trash($id)
    {
        return $this->jsonResponse(data: $this->categoryRepository->trash($id), statusCode: Response::HTTP_OK);
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->find($id);

        return $this->jsonResponse(
            data: $this->categoryRepository->restore($category),
            statusCode: Response::HTTP_OK
        );
    }
}
