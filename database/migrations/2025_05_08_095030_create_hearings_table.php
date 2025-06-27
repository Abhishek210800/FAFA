<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('hearings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_case_id')->constrained('court_cases')->onDelete('cascade');
            $table->date('hearing_date');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hearings');
    }
};
