<?php

namespace App\Http\Resources\Minimize;

use App\Http\Resources\EntryResource;
use App\Http\Resources\RoleResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMinimizeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var User $this */
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
        ];
    }
}
