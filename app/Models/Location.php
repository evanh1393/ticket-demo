<?php

namespace App\Models;

use App\Enums\LocationBrand;
use App\Traits\GenerateDisplayId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Location extends Model
{
    use HasFactory, GenerateDisplayId;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'address',
        'city',
        'state',
        'zip',
        'brand',
        'display_id',
        'phone',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'brand' => LocationBrand::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->display_id)) {
                $model->display_id = self::generateDisplayId('LOC');
            }
        });

        static::addGlobalScope('userLocations', function ($builder) {
            $user = Auth::user();
            if ($user && $user->hasRole('Store Manager')) {
                $builder->whereHas('users', function ($query) use ($user) {
                    $query->where('users.id', $user->id);
                });
            }
        });
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'location_user');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

}
