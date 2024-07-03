<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('licence_plate')->unique();
            $table->foreignId('vehicle_id')->constrained();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('start_odometer');
            $table->unsignedInteger('end_odometer');
            $table->unsignedDouble('carbon_intensity')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
