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
        Schema::create('court_cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number');
            $table->string('plaintiff');
            $table->string('defendant');
            $table->string('status'); // e.g., pending, resolved
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('court_cases');
    }
};
