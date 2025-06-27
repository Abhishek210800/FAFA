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
        Schema::create('case_complaints', function (Blueprint $table) {
            $table->id();
            $table->string('court')->nullable();  // Allowing NULL values for court
            $table->string('judge')->nullable();  // Allowing NULL values for judge
            $table->string('plaintiff');
            $table->string('defendant');
$table->string('case_number')->nullable();  // Allowing NULL values for case_number
            $table->date('reference_date');
            $table->string('order_file_path')->nullable();
            $table->string('case_file_path')->nullable();
            $table->string('status')->default('Active');
            $table->foreignId('court_id')->nullable()->constrained()->onDelete('set null');  // Foreign key for court
            $table->foreignId('judge_id')->nullable()->constrained()->onDelete('set null');  // Foreign key for judge
            $table->foreignId('case_model_id')->nullable()->constrained()->onDelete('set null');  // Foreign key for case model
            $table->string('order_file')->nullable();  // Path for order file (optional)
            $table->string('case_file')->nullable();  // Path for case file (optional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_complaints');
    }
};
