<?php

namespace App\Imports;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProjectImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Project|null
     */
    public function model(array $row): ?Project
    {
        $existingProject = Project::query()
            ->where('licence_plate', $row['license_plate'])
            ->first();

        if ($existingProject) {
            Log::error("The Project already exists in the database. Excel ID: {$row['prj_id']}");

            return null;
        }

        return new Project([
            'id' => $row['prj_id'],
            'licence_plate' => $row['license_plate'],
            'vehicle_id' => $row['v_id'],
            'start_date' => Carbon::parse($row['start_date']),
            'end_date' => Carbon::parse($row['end_date']),
            'start_odometer' => $row['start_odo'],
            'end_odometer' => $row['last_odo'],
        ]);
    }
}
