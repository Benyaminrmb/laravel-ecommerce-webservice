<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserEntry extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'type', 'verified_at', 'entry', 'is_main'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(related:User::class);
    }
}
