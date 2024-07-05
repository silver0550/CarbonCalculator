<?php

namespace App\Repositories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository extends BaseRepository
{
    protected function determineModelClass(): string
    {
        return Project::class;
    }

    public function getAllWithVehicles(?array $only = null): Collection
    {
        return $this->model::with([
            'vehicle' => function($query) use($only) {
                if ($only) {
                    if (!in_array('id', $only)) {

                        $only[] = 'id';
                    }

                    $query->select($only);
                }
            }
        ])->get();
    }

    public function getGroupedByYears(): Collection
    {
        return Project::query()
            ->selectRaw('YEAR(end_date) as year, SUM(carbon_intensity) as totalCarbonIntensity')
            ->groupByRaw('YEAR(end_date)')
            ->get();
    }
}
