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
                    $only = explode(',', implode(',', $only));
                    if (!in_array('id', $only)) {
                        $only[] = 'id';
                    }
                    $query->select($only);
                }
            }
        ])->get();
    }
}
