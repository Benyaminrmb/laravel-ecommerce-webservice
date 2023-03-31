<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Upload extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['path', 'deleted_at'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(
            related: User::class
        );
    }
}
