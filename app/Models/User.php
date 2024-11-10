<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * Get the tickets created by the user.
     */
    public function createdTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'created_by');
    }

    /**
     * Get the tickets updated by the user.
     */
    public function updatedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'updated_by');
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'location_user');
    }

    /**
     * Scope a query to only include users of a given brand.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $brand
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterByBrand($query, $brand)
    {
        return $query->whereHas('locations', function ($query) use ($brand) {
            $query->where('brand', $brand);
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
