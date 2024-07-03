<?php

use App\Http\Controllers\ProfileController;
use App\Imports\EmproviaImport;
use App\Imports\VehicleImport;
use App\Models\Project;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

//    Excel::import(new EmproviaImport(), 'C:\Users\Gacs\Projects\TesztProjects\emprovia\storage\app\public\mitigia_feladat1.xlsx');

    $exitCode = Artisan::call('excel:import', [
        '--from' => 'C:\Users\Gacs\Projects\TesztProjects\emprovia\storage\app\public\mitigia_feladat1.xlsx',
        '--sheets' => 'vehicle,project,carbon_intensity',
        '--to' => 'VehicleImport,ProjectImport,CarbonIntensityImport',
    ]);

    dd($exitCode);



});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
