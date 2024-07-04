<?php

namespace App\Repositories;

use App\Models\CarbonIntensity;

class CarbonIntensityRepository extends BaseRepository
{
    protected function determineModelClass(): string
    {
        return CarbonIntensity::class;
    }

    public function getCarbonIntensityByYear(int $year): int
    {
        return $this->model::query()
            ->where('year', $year)
            ->where('country', 'Hungary')
            ->first()
            ?->carbon_intensity ?? 0;
    }


}
