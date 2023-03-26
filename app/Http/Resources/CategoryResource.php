<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /* @var Category $this */
        $result = [
            'id' => $this->id,
            'name' => $this->name,
        ];
        if ($this->children()->count()) {
            $result['children'] = CategoryResource::collection($this->children);
        }

        return $result;
    }
}
