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
        Schema::create('mediators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mediation_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type')->nullable(); 
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mediators');
    }
};
