<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\BrandRequest;
use App\Http\Resources\BrandResource;
use App\Interface\BrandRepositoryInterface;
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
        $newBrand = [
            'name' => $request->get('name'),
        ];
        if (isset($request->logo_id)) {
            $newBrand['logo_id'] = $request->get('logo_id');
        }
        $brand = $this->brandRepository->create($newBrand);

        return $this->jsonResponse(data: BrandResource::make($brand), statusCode: Response::HTTP_CREATED);
    }

    public function update(Brand $brand, BrandRequest $request)
    {
        $newBrand = [
            'name' => $request->get('name'),
        ];
        if (isset($request->logo_id)) {
            $newBrand['logo_id'] = $request->get('logo_id');
        }
        $brand = $this->brandRepository->update($brand, $newBrand);

        return $this->jsonResponse(data: $brand, statusCode: Response::HTTP_OK);
    }

    public function trash(Brand $brand)
    {
        return $this->jsonResponse(data: $this->brandRepository->trash($brand), statusCode: Response::HTTP_OK);
    }

    public function restore($brand_id)
    {
        $brand = Brand::withTrashed()->find($brand_id);

        return $this->jsonResponse(
            data: $this->brandRepository->restore($brand),
            statusCode: Response::HTTP_OK
        );
    }
}
