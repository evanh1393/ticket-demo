<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

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
    ];

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Generates a unique display identifier.
     *
     * @return string A 7-character uppercase string derived from a unique MD5 hash prefixed by loc_.
     */
    public function generateDisplayId(): string
    {
        // Ensure the string is unique
        do {
            $displayId = 'LOC_' . strtoupper(substr(md5(uniqid(rand(), true)), 0, 7));
        } while ($this->displayIdExists($displayId));

        return $displayId;
    }

}