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
        $data = $this->carbonIntensityService->collectDataToReport()->toArray();

        return Inertia::render('teszt', [
            'data' => $data,
        ]);
    }
}
