<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable=['name','parent_id'];
    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(related: Category::class, foreignKey: 'parent_id');
    }
}
