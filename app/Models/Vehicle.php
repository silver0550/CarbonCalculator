<?php

namespace App\Models;

use App\Enums\FuelTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Vehicle
 *
 * @property int $id
 * @property int $year
 * @property string $manufacturer
 * @property string $model
 * @property string $type
 * @property FuelTypeEnum $fuel_type
 * @property int|null $wltp_energy_consumption
 * @property int|null $nedc_energy_consumption
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class Vehicle extends Model
{
    const EC_DEFAULT = 188;

    use HasFactory;
    use softDeletes;

    protected $table = 'vehicles';
    protected $guarded = [];
    protected $casts = [
        'fuel_type' => FuelTypeEnum::class,
    ];
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function getEnergyConsumptionAttribute(): int
    {
        return $this->wltp_energy_consumption
            ?? $this->nedc_energy_consumption
            ?? self::EC_DEFAULT;

    }
}
