<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Interface\Repository\BrandRepositoryInterface;
use App\Models\Brand;
use Symfony\Component\HttpFoundation\Response;

class BrandController extends Controller
{
    private BrandRepositoryInterface $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function index()
    {
        $brands = $this->brandRepository->getAll();

        return $this->jsonResponse(data: BrandResource::collection($brands));
    }

    public function store(BrandRequest $request)
    {
        $data = $request->validated();
        #todo upload logo
        //.......

        $brand = $this->brandRepository->create($data);
        return $this->jsonResponse(data: BrandResource::make($brand), statusCode: Response::HTTP_CREATED);
    }

    public function update(BrandRequest $request , $id)
    {
        $data = $request->validated();
        #todo upload logo
        //.......

        $brand = $this->brandRepository->update($id, $data);
        return $this->jsonResponse(data: $brand, statusCode: Response::HTTP_ACCEPTED);
    }

    public function trash($id)
    {
        return $this->jsonResponse(data: $this->brandRepository->trash($id), statusCode: Response::HTTP_OK);
    }

    public function restore($id)
    {
        $brand = Brand::withTrashed()->find($id);

        return $this->jsonResponse(
            data: $this->brandRepository->restore($brand),
            statusCode: Response::HTTP_OK
        );
    }
}
