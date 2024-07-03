<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use Illuminate\Support\Collection;

class CarbonIntensityService
{

    public function __construct(private readonly ProjectRepository $projectRepository)
    {
    }

    public function collectDataToReport(): Collection
    {
        $projects = $this->projectRepository->getAllWithVehicles();
        $carbonIntensities = CarbonIntensityCalculator::collection($projects);

        return $projects->map(function ($project) use ($carbonIntensities) {
            $match = $carbonIntensities->firstWhere('id', $project->id);
            $vehicle = $project->vehicle;
            $vehicleName = "{$vehicle->manufacturer} {$vehicle->model} {$vehicle->year} {$vehicle->type}" ;

            return [
                'id' => $project->id,
                'vehicleName' => $vehicleName,
                'startProject' => $project->start_date,
                'endProject' => $project->end_date,
                'runningPower' => 'Ezt még ki kell találni',
                'carbonIntensity' => number_format($match['carbonIntensity'], 2, '.', ' ')
            ];
        });
    }

    public function groupProjectsByYear(): Collection
    {
//        TODO:ITT TARTOK
    }
}
