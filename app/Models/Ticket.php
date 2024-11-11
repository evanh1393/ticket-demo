<?php

namespace App\Models;

use App\Enums\TicketDepartment;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'priority',
        'department',
        'location_id',
        'display_id',
        'category',
        'sub_category',
        'assigned_to',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'location_id' => 'integer',
        'assigned_to' => 'integer',
        'status' => TicketStatus::class,
        'department' => TicketDepartment::class,
    ];

    /**
     * Generates a unique display identifier.
     *
     * @return string A 7-character uppercase string derived from a unique MD5 hash prefixed by TCKT_.
     */
    public static function generateDisplayId(): string
    {
        for ($i = 0; $i < 5; $i++) {
            $displayId = 'TKT_' . substr(md5(uniqid(rand(), true)), 0, 7);
            if (!self::displayIdExists($displayId)) {
                return $displayId;
            }
        }

        throw new \Exception('Failed to generate a unique display ID after 5 attempts.');
    }

    /**
     * Checks if a display ID already exists in the database.
     *
     * @param string $displayId
     * @return bool
     */
    protected static function displayIdExists(string $displayId): bool
    {
        return self::where('display_id', $displayId)->exists();
    }

    /**
     * Boot method to set the created_by and updated_by fields automatically.
     *
     * We handle basic ticket viewing capabilities here.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->created_by)) {
                $model->created_by = Auth::id();
            }
            if (is_null($model->updated_by)) {
                $model->updated_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (is_null($model->updated_by)) {
                $model->updated_by = Auth::id();
            }
        });

        static::addGlobalScope('userTickets', function ($builder) {
            $user = Auth::user();
            if ($user->hasRole('Store Manager')) {
                $builder->whereIn('location_id', $user->locations->pluck('id'));
            }

            if ($user->hasRole('Basic User')) {
                $builder->where('created_by', $user->id);
            }
        });
    }

    public function actions(): HasMany
    {
        return $this->hasMany(Action::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the user who created the action.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated the action.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
