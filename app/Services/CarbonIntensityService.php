<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use Illuminate\Support\Collection;

class CarbonIntensityService
{

    public function __construct(private readonly ProjectRepository $projectRepository)
    {
    }

    public function collectDataToReportFromAllProjects(): Collection
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

    public function groupProjectsByYear(): array
    {
        $return = $this->projectRepository
            ->getGroupedByYears();
        foreach ($return as $projects) {
            $projects->totalCarbonIntensity = number_format($projects->totalCarbonIntensity, 2, '.', ' ');
        }
        return $return->toArray();
    }
}
