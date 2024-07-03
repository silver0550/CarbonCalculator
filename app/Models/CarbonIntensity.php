<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarbonIntensity extends Model
{
    use HasFactory;

    protected $table = 'carbon_intensities';
    protected $guarded = ['id'];
}
