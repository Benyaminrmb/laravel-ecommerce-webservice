<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UploadPolicy
{
    public function update(User $user,Upload $upload): bool
    {
        return $user->id === $upload->user_id;
    }
    public function trash(User $user,Upload $upload): bool
    {
        return $user->id === $upload->user_id;
    }
    public function delete(User $user): bool
    {
        return $user->role_id === 3;
    }
}
