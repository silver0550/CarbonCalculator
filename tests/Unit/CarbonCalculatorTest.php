<?php

namespace Tests\Unit;

use App\Models\CarbonIntensity;
use App\Models\Project;
use App\Models\Vehicle;
use App\Services\CarbonIntensityCalculator;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarbonCalculatorTest extends TestCase
{
    use RefreshDatabase;


    public function testDistanceCalculateIsCorrect(): void
    {
        $project = Project::factory()->create(['carbon_intensity' => null]);
        $project->start_odometer = 100;
        $project->end_odometer = 111;

        $calculator = app()->make(CarbonIntensityCalculator::class, ['project' => $project]);

        $this->assertEquals(11, $calculator->getDistanceTravelled());
    }

    public function testEnergyConsumptionCalculateIsCorrect(): void
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

        $this->assertTrue(isset($result));
        $this->assertEquals(100, $result[0]);
        $this->assertEquals(100, $result[1]);
        $this->assertEquals(18, $result[2]);
    }

    public function testTotalEnergyConsumptionCalculateIsCorrect(): void
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

        $this->assertEquals(1800, $calculator->getTotalConsumption());
    }

    public function testCarbonIntensityIsCorrect(): void
    {
        $project = Project::factory()->create([
            'end_date' => Carbon::parse('2023-01-01')
        ]);

        CarbonIntensity::factory()->create([
            'year' => 2023,
            'carbon_intensity' => 1000
        ]);

        $calculator = app()->make(CarbonIntensityCalculator::class, ['project' => $project]);

        $this->assertEquals(1000, $calculator->getCarbonIntensity());
    }

    public function testCarbonIntensityCalculatorIsCorrect(): void
    {
        $project = Project::factory()->create([             //distance = 10000 km
            'start_odometer' => 1,
            'end_odometer' => 10001,
            'end_date' => Carbon::parse('2023-01-01'),
            'vehicle_id' => Vehicle::factory()->create([    //EnergyConsumption = 18
                'wltp_energy_consumption' => null,
                'nedc_energy_consumption' => null,
            ])->id,
        ]);

        CarbonIntensity::factory()->create([
            'year' => 2023,
            'carbon_intensity' => 100
        ]);

        $calculator = app()->make(CarbonIntensityCalculator::class, ['project' => $project]);

        $this->assertEquals(180000, $calculator->calculate());
    }
}
