<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Project
 *
 * @property int $id
 * @property string $licence_plate
 * @property int $vehicle_id
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property int $start_odometer
 * @property int $end_odometer
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property Vehicle $vehicle
 *
 * @property-read int $distanceTravelled
 */

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'projects';
    protected $guarded = [];

    protected $dates = [
        'start_date',
        'end_date',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function getDistanceTravelledAttribute(): int
    {
        return $this->end_odometer - $this->start_odometer;
    }
}
