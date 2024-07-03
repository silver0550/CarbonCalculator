<?php

namespace App\Services;

use App\Contracts\CalculableInterface;
use App\Models\Project;
use App\Repositories\CarbonIntensityRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CarbonIntensityCalculator implements CalculableInterface
{
    private int $distanceTravelled; //km
    private int $energyConsumption; //kWh/100km
    private float $totalConsumption; //kWh/100km
    private int $carbonIntensity; //gC02eq/kWh

    public function __construct(
        private readonly Project $project,
        private readonly CarbonIntensityRepository $carbonIntensityRepository)
    {
        $this->distanceTravelled = $this->project->distanceTravelled;
        $this->energyConsumption = $this->project->vehicle->energyConsumption;
        $this->carbonIntensity = $this->carbonIntensityRepository
            ->getCarbonIntensityByYear(Carbon::parse($this->project->end_date)->year);

        $this->totalConsumption = $this->calculateTotalConsumption();
    }

    public function calculate(): float
    {
        return $this->totalConsumption * $this->carbonIntensity;
    }

    public static function collection(Collection $collection): Collection
    {
        return $collection->map(function($project) {
            return [
                'projectId' => $project->id,
                'carbonIntensity' => app()
                    ->make(CarbonIntensityCalculator::class, ['project' => $project])
                    ->calculate(),
            ];
        });
    }

    private function calculateTotalConsumption(): float
    {
        return ($this->distanceTravelled / 100) * $this->energyConsumption;
    }
}
