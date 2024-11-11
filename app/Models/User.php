<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * This class represents a user in the application. It extends the Authenticatable class provided by Laravel,
 * which includes authentication and authorization functionalities. The User class also uses several traits
 * to add additional functionalities such as factory creation, notifications, and role-based permissions.
 *
 * @package App\Models
 */
class User extends Authenticatable
{
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
     *
     * This method defines a one-to-many relationship between the User and Ticket models.
     * It returns all tickets that were created by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'created_by');
    }

    /**
     * Get the location names associated with the user.
     *
     * This accessor method returns a comma-separated string of location titles
     * associated with the user.
     *
     * @return string
     */
    public function getLocationNameAttribute(): string
    {
        return $this->locations->pluck('title')->implode(', ');
    }

    /**
     * Get the brand names associated with the user.
     *
     * This accessor method returns a comma-separated string of brand names
     * associated with the user.
     *
     * @return string
     */
    public function getBrandNameAttribute(): string
    {
        return $this->locations->pluck('brand')->implode(', ');
    }

    /**
     * Get the tickets updated by the user.
     *
     * This method defines a one-to-many relationship between the User and Ticket models.
     * It returns all tickets that were updated by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function updatedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'updated_by');
    }

    /**
     * Get the locations associated with the user.
     *
     * This method defines a many-to-many relationship between the User and Location models.
     * It returns all locations that are associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class, 'location_user');
    }

    /**
     * Get the attributes that should be cast.
     *
     * This method returns an array of attributes that should be type-cast to specific types.
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
