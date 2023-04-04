<?php

namespace App\Http\Resources;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /* @var Brand $this */
        $result = [
            'id' => $this->id,
            'name' => $this->name,
        ];
        if ($this->logo) {
            $result['logo'] = UploadResource::make($this->logo);
        }

        return $result;
    }
}
