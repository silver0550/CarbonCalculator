<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Vehicle;
use App\Services\CarbonIntensityCalculator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CarbonCalculatorTest extends TestCase
{
    use RefreshDatabase;


    public function testDistanceIsRight(): void
    {
        $project = Project::factory()->create(['carbon_intensity' => null]);
        $project->start_odometer = 100;
        $project->end_odometer = 111;

        $calculator = app()->make(CarbonIntensityCalculator::class, ['project' => $project]);

        $this->assertEquals($calculator->getDistanceTravelled(), 11);
    }

    public function testEnergyConsumptionIsRight(): void
    {
        $testData = [
            [
                'wltp_energy_consumption' => 1000,
                'nedc_energy_consumption' => 100,
            ],
            [
                'wltp_energy_consumption' => null,
                'nedc_energy_consumption' => 100,
            ],
            [
                'wltp_energy_consumption' => null,
                'nedc_energy_consumption' => null,
            ],
        ];

        foreach ($testData as $data) {
            Project::factory()->create([
                'vehicle_id' => Vehicle::factory()->create($data)->id,
            ]);
        }

        foreach (Project::all() as $index => $project) {
            $calculator = app()->make(CarbonIntensityCalculator::class, ['project' => $project]);

            $result[$index] = $calculator->getEnergyConsumption();
        }

        $this->assertEquals($result[0], 100);
        $this->assertEquals($result[1], 100);
        $this->assertEquals($result[2], 18);
    }

    public function testTotalEnergyConsumptionIsRight(): void
    {
        $project = Project::factory()->create([          //distance = 10000 km
            'start_odometer' => 1,
            'end_odometer' => 10001,
            'vehicle_id' => Vehicle::factory()->create([ //EnergyConsumption = 18
                'wltp_energy_consumption' => null,
                'nedc_energy_consumption' => null,
            ])->id,
        ]);

        $calculator = app()->make(CarbonIntensityCalculator::class, ['project' => $project]);

        $this->assertEquals($calculator->getTotalConsumption(), 1800);
    }

    //carbon intensiti
    // calculator
}
