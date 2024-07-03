<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EmproviaImport implements WithMultipleSheets
{

    public function __construct(private readonly ?array $sheets = null)
    {
    }

    public function sheets(): array
    {

        return $this->sheets ??
            [
                'vehicle' => new VehicleImport(),
                'project' => new ProjectImport(),
                'carbon_intensity' => new CarbonIntensityImport(),
            ];

    }
}
