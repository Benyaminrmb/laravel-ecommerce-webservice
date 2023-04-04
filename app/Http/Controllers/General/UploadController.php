<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\UploadRequest;
use App\Http\Resources\UploadResource;
use App\Repositories\UploadRepository;
use ErrorException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    protected UploadRepository $uploadRepository;

    public function __construct(UploadRepository $uploadRepository)
    {
        $this->uploadRepository = $uploadRepository;
    }

    public function store(UploadRequest $request)
    {
        $upload = $this->uploadRepository->create($request->only('title','file'));
        return $this->jsonResponse(data:UploadResource::make($upload),statusCode: 201);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UploadRequest $request, $id)
    {
        $upload = $this->get($id);
        $this->authorize('update', $upload);
        $this->uploadRepository->update($id,$request->validated());
        $upload = $this->get($id);
        return $this->jsonResponse(data:UploadResource::make($upload));
    }


    private function get($id){
        if(!$upload = $this->uploadRepository->get($id)){
            throw new HttpResponseException($this->jsonResponse(status: false, message: __('general.notFound'), statusCode: 404));
        }
        return $upload;
    }

    public function show($id)
    {
        return $this->jsonResponse(data: UploadResource::make($this->get($id)));
    }

    /**
     * @throws AuthorizationException
     */
    public function softDelete($id)
    {
        $upload = $this->get($id);
        $this->authorize('trash', $upload);
        $this->uploadRepository->trash($id);
        return $this->jsonResponse(message: __('general.trashed'));
    }

    /**
     * @throws AuthorizationException
     */
    public function delete($id)
    {
        $upload = $this->get($id);
        $this->authorize('delete', $upload);
        $this->uploadRepository->delete($id);
        return $this->jsonResponse(message: __('general.removed'));
    }
    public function restore($id)
    {
        $this->uploadRepository->restore($id);
        return $this->jsonResponse(message: __('general.restore'));
    }

}
