<?php

namespace App\Http\Controllers;

use App\Services\CarbonIntensityService;
use Illuminate\Support\Facades\Artisan;
use Inertia\Inertia;
use Inertia\Response;

class CarbonIntensityController extends Controller
{

    public function __construct(private readonly CarbonIntensityService $carbonIntensityService)
    {
    }

    public function index(): Response
    {
        $filePath = 'C:\Users\Gacs\Projects\TesztProjects\emprovia\storage\app\public\mitigia_feladat1.xlsx';

        Artisan::call('excel:import', [
            '--from' => $filePath,
            '--sheets' => 'vehicle,project,carbon_intensity',
            '--to' => 'VehicleImport,ProjectImport,CarbonIntensityImport'
        ]);
        dd('end');
        $data = $this->carbonIntensityService->collectDataToReport()->toArray();
//        dd($data);
        return Inertia::render('teszt', [
            'data' => $data,
        ]);
    }
}
