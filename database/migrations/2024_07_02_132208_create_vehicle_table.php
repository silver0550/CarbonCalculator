<?php

use App\Enums\FuelTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('year');
            $table->string('manufacturer');
            $table->string('model');
            $table->string('type');
            $table->enum('fuel_type', getEnumValues(FuelTypeEnum::class));
            $table->unsignedSmallInteger('wltp_energy_consumption')->nullable()
                ->comment('Consumption data using the WLTP methodology');
            $table->unsignedSmallInteger('nedc_energy_consumption')->nullable()
                ->comment('Consumption data using the NEDC methodology');
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
