<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserEntryTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * @var mixed|string
     */
    public mixed $token;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',

        'password',
        'role_id',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(
            related: Role::class, foreignKey: 'role_id'
        );
    }

    public function sendVerificationNotification()
    {
        // todo send Notification to user
    }

    public function entries(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(related: UserEntry::class);
    }

    public function latestEntry(): UserEntry
    {
        return $this->entries()->latest()->first();
    }

    public function scopeSearchEntry($query, string $type, string $entry)
    {
        $query->whereHas('entries', function ($sub_query) use ($entry, $type) {
            $sub_query->where('type', $type)
                ->where('entry', $entry);
        });
    }

    public function routeNotificationForMail(Notification $notification): array|string
    {
        return $this->entries()
            ->where('type', UserEntryTypeEnum::EMAIL->value)->first()->entry;
    }
}
