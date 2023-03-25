<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Interface\CategoryRepositoryInterface;
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
        $newCategory = [
            'name' => $request->get('name'),
        ];
        if (isset($request->parent_id)) {
            $newCategory['parent_id'] = $request->get('parent_id');
        }
        $category = $this->categoryRepository->create($newCategory);

        return $this->jsonResponse(data: $category, statusCode: Response::HTTP_CREATED);
    }

    public function update(Category $category, CategoryRequest $request)
    {
        $newCategory = [
            'name' => $request->get('name'),
        ];
        if (isset($request->parent_id)) {
            $newCategory['parent_id'] = $request->get('parent_id');
        }
        $category = $this->categoryRepository->update($category, $newCategory);

        return $this->jsonResponse(data: $category, statusCode: Response::HTTP_OK);
    }

    public function trash(Category $category)
    {
        return $this->jsonResponse(data: $this->categoryRepository->trash($category), statusCode: Response::HTTP_OK);
    }

    public function restore($category_id)
    {
        $category = Category::withTrashed()->find($category_id);

        return $this->jsonResponse(data: $this->categoryRepository->restore($category), statusCode: Response::HTTP_OK);
    }
}
