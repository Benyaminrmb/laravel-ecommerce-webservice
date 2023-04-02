<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Repositories\UploadRepository;
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
        $validatedData = $request->validate([
            'upload' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'title' => 'nullable|string|max:255',
        ]);

        $file = $request->file('upload');
        $path = $this->uploadRepository->save($file);

        $fileModel = $user->uploads()->create([
            'path' => $path,
            'title' => $request->input('title'),
        ]);

        return response()->json(['path' => $path, 'id' => $fileModel->id]);
    }

    public function show($id)
    {
        return $this->jsonResponse(data: UploadResource::make($this->get($id)));
    }

}
