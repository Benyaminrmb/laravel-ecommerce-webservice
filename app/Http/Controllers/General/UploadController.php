<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\General\UploadRequest;
use App\Http\Resources\UploadResource;
use App\Repositories\UploadRepository;
use ErrorException;
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
        $user = \Auth::user();

        $file = $request->file('file');
        $path = $this->uploadRepository->save($file);



        $fileModel = $user->uploads()->create([
            'path' => $path,
            'title' => $request->input('title'),
        ]);

        return $this->jsonResponse(data:UploadResource::make($fileModel),statusCode: 201);
    }

    public function update(UploadRequest $request,$id)
    {
        $user = \Auth::user();
        //todo update an image only if the same $user created it.
        $upload = $this->get($id);
        $file = $request->file('file');
        $path = $this->uploadRepository->update($upload,$file);




        $upload->update(array_filter([
            'path' => $path,
            'title' => $request->input('title')
        ]));

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

}
