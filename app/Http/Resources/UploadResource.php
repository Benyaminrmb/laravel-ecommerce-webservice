<?php

namespace App\Http\Resources;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UploadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /* @var Upload $this */
        return [
            'id' => $this->id,
            'path' => $this->path,
            'title' => $this->title,
            'user' => UserResource::make($this->user),
        ];
    }
}
