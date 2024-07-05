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
        Schema::create('carbon_intensities', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->unsignedSmallInteger('year');
            $table->unsignedSmallInteger('carbon_intensity');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['country', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carbon_intensities');
    }
};
