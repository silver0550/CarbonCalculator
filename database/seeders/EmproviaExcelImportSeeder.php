<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class EmproviaExcelImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = 'C:\Users\Gacs\Projects\TesztProjects\emprovia\storage\app\public\mitigia_feladat1.xlsx';

        Artisan::call('excel:import', [
            '--from' => $filePath,
            '--sheets' => 'vehicle,project,carbon_intensity',
            '--to' => 'VehicleImport,ProjectImport,CarbonIntensityImport'
        ]);
    }
}
