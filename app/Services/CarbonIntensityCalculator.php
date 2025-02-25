<?php

namespace App\Services;

use App\Contracts\CalculableInterface;
use App\Models\Project;
use App\Repositories\CarbonIntensityRepository;
use App\Repositories\ProjectRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CarbonIntensityCalculator implements CalculableInterface
{
    private int $distanceTravelled; //km
    private float $energyConsumption; //kWh/100km
    private float $totalConsumption; //kWh/100km
    private int $carbonIntensity; //gC02eq/kWh

    public function __construct(
        private Project                            $project,
        private readonly CarbonIntensityRepository $carbonIntensityRepository,
        private readonly ProjectRepository         $projectRepository,
    )
    {
        $this->init();
    }

    public function setProject(Project $project): self
    {
        $this->project = $project;
        $this->init();

        return $this;
    }

    public function calculate(bool $force = false): float
    {
        if (!is_null($this->project->carbon_intensity) && !$force) {

            return $this->project->carbon_intensity;
        }

        $carbonIntensity = $this->totalConsumption * $this->carbonIntensity;

        $this->projectRepository->update($this->project->id, [
            'carbon_intensity' => $carbonIntensity,
        ]);

        return $carbonIntensity;
    }

    public static function collection(Collection $projects, bool $force = false): ?Collection
    {
        try {
            $carbonIntensityCalculator = app()
                ->make(CarbonIntensityCalculator::class, ['project' => $projects->first()]);
        } catch (BindingResolutionException $e) {
            Log::error($e->getMessage());

            return null;
        }

        return $projects->map(function ($project) use ($force, &$carbonIntensityCalculator) {
            return [
                'id' => $project->id,
                'carbonIntensity' => $carbonIntensityCalculator->setProject($project)
                    ->calculate($force),
            ];
        });
    }

    private function init(): void
    {
        if (is_null($this->project->carbon_intensity)) {

            $this->distanceTravelled = $this->project->distanceTravelled; // távolság
            $this->energyConsumption = $this->project->vehicle->energyConsumption; // energia tpis
            $this->carbonIntensity = $this->carbonIntensityRepository //260
                ->getCarbonIntensityByYear(Carbon::parse($this->project->end_date)->year);
            $this->totalConsumption = $this->calculateTotalConsumption();
        }
    }

    private function calculateTotalConsumption(): float
    {
        return ($this->distanceTravelled / 100) * $this->energyConsumption;
    }

    //========================= GETTERS ==============================

    public function getDistanceTravelled(): ?int
    {
        return $this->distanceTravelled ?? null;
    }

    public function getEnergyConsumption(): ?int
    {
        return $this->energyConsumption ?? null;
    }

    public function getTotalConsumption(): ?float
    {
        return $this->totalConsumption ?? null;
    }

    public function getCarbonIntensity(): ?int
    {
        return $this->carbonIntensity ?? null;
    }
}
