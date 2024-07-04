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
        $projectReports = $this->carbonIntensityService->collectDataToReportFromAllProjects()->toArray();
        $groupedProjectsByYear = $this->carbonIntensityService->groupProjectsByYear();

        return Inertia::render('carbon_intensity_report', [
            'report' => $projectReports,
            'groupedProjects' => $groupedProjectsByYear,
        ]);
    }
}
