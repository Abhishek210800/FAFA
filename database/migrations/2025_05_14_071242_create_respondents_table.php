<?php

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
        Schema::create('respondents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mediation_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('father');
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->text('address');
            $table->foreignId('state_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->string('district');
            $table->string('pincode');
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respondents');
    }
};
