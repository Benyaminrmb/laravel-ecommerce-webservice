<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var User $this */
        $result = [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'entries' => EntryResource::collection($this->entries),
            'role' => RoleResource::make($this->role),
        ];
        if (isset($this->token) && !empty($this->token)) {
            $result['token'] = $this->token;
        }

        return $result;
    }
}
