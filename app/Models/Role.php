<?php

namespace App\Models;

use App\Enums\Role as RoleEnums;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable=['name'];
    protected $casts=[
        'name'=> RoleEnums::class
    ];
}
