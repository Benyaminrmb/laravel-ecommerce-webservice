<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\CategoryRequest;
use App\Http\Resources\CategoryResource;
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
        return $this->jsonResponse(data:CategoryResource::collection($categories));
    }

    public function store(CategoryRequest $request)
    {
        $newCategory=[
            'name'=>$request->get('name'),
        ];
        if(isset($request->parent_id)) {
            $newCategory['parent_id'] = $request->get('parent_id');
        }
        $category=$this->categoryRepository->create($newCategory);
        return $this->jsonResponse(data:$category,statusCode: Response::HTTP_CREATED);
    }

}
