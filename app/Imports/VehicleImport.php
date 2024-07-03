<?php

namespace App\Imports;

use App\Enums\FuelTypeEnum;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use ValueError;

class VehicleImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Vehicle|null
     */
    public function model(array $row): ?Vehicle
    {
        try {
            $fuelType = FuelTypeEnum::from($row['fuel_type']);
        } catch (ValueError $e) {
            Log::error("The Vehicle fuel type is invalid.
                Excel ID: {$row['v_id']}, fuel type: {$row['fuel_type']}");

            return null;
        }

        $existingVehicle = Vehicle::query()
            ->where('year', $row['v_year'])
            ->where('manufacturer', $row['v_manufacturer'])
            ->where('model', $row['v_model'])
            ->where('fuel_type', $fuelType)
            ->where('wltp_energy_consumption', $row['wltp_energy_consumption'])
            ->where('nedc_energy_consumption', $row['nedc_energy_consumption'])
            ->first();

        if ($existingVehicle) {
            Log::error("The Vehicle already exists in the database. Excel ID: {$row['v_id']}");

            return null;
        }

        return new Vehicle([
            'id' => $row['v_id'],
            'year' => $row['v_year'],
            'manufacturer' => $row['v_manufacturer'],
            'model' => $row['v_model'],
            'type' => $row['v_type'],
            'fuel_type' => $fuelType,
            'wltp_energy_consumption' => $row['wltp_energy_consumption'],
            'nedc_energy_consumption' => $row['nedc_energy_consumption'],
        ]);
    }
}
