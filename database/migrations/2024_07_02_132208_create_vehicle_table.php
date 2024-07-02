<?php

use App\Enums\FuelTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('year');
            $table->string('manufacturer');
            $table->string('model');
            $table->string('type');
            $table->enum('fuel_type', getEnumValues(FuelTypeEnum::class));
            $table->unsignedInteger('wltp_energy_consumption');
            $table->unsignedInteger('nedc_energy_consumption');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle');
    }
};
