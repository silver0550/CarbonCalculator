<?php

namespace App\Imports;

use App\Models\CarbonIntensity;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CarbonIntensityImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return CarbonIntensity|null
     */
    public function model(array $row): ?CarbonIntensity
    {

        $existingCarbonIntensity = CarbonIntensity::query()
            ->where('country', $row['country'])
            ->where('year', $row['year'])
            ->where('carbon_intensity', $row['carbon_intensity'])
            ->first();

        if ($existingCarbonIntensity) {
            Log::error('The CarbonIntensity already exists in the database.'
                . " Country: {$row['country']}, Year: {$row['year']} }");

            return null;
        }

        return new CarbonIntensity([
            'country' => $row['country'],
            'year' => $row['year'],
            'carbon_intensity' => $row['carbon_intensity'],
        ]);
    }
}
