<?php

namespace App\Models;

use App\Enums\FuelTypeEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    const EC_DEFAULT = 188;

    use HasFactory;

    protected $table = 'vehicles';
    protected $casts = [
        'fuel_type' => FuelTypeEnum::class,
        'year' => Carbon::class,
    ];
}
