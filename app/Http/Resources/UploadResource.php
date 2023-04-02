<?php

namespace App\Http\Resources;

use App\Http\Resources\Minimize\UserMinimizeResource;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class UploadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /* @var Upload $this */
        return [
            'id' => $this->id,
            'path' => asset(Storage::url($this->path)),
            'size' => Storage::disk('public')->size($this->path),
            'mime' => Storage::disk('public')->mimeType($this->path),
            'title' => $this->title,
            'user' => UserMinimizeResource::make($this->user),
        ];
    }
}
