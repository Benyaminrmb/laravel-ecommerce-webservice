<?php

namespace App\Http\Resources;

use App\Models\UserEntry;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var UserEntry $this */
        return [
            'id'=>$this->id,
            'type'=>$this->entry,
            'entry'=>$this->entry,
            'is_main'=>$this->is_main,
            'is_verified'=> (bool)$this->verified_at,
        ];
    }
}
