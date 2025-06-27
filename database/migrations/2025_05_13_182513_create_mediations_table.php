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
        Schema::create('mediations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('court_id')->nullable();
        $table->foreignId('judge_id')->nullable();
        $table->string('case_number');
        $table->date('reference_date')->nullable();
        $table->date('mediation_date')->nullable();
        $table->string('order_file')->nullable();
        $table->string('case_file')->nullable();
        
        // Complainant
        $table->string('complainant_name');
        $table->string('complainant_father');
        $table->date('complainant_dob')->nullable();
        $table->string('complainant_gender');
        $table->text('complainant_address');
        $table->foreignId('complainant_state_id')->nullable();
        $table->foreignId('complainant_city_id')->nullable();
        $table->string('complainant_district');
        $table->string('complainant_pincode');
        $table->string('complainant_mobile');
        $table->string('complainant_email')->nullable();
        $table->string('complainant_id_proof')->nullable();

        // Defendant (similar structure)
        $table->string('defendant_name');
        $table->string('defendant_father');
        $table->date('defendant_dob')->nullable();
        $table->string('defendant_gender');
        $table->text('defendant_address');
        $table->foreignId('defendant_state_id')->nullable();
        $table->foreignId('defendant_city_id')->nullable();
        $table->string('defendant_district');
        $table->string('defendant_pincode');
        $table->string('defendant_mobile');
        $table->string('defendant_email')->nullable();

        // Case classification
        $table->foreignId('subject_id')->nullable();
        $table->foreignId('issue_id')->nullable();
        $table->foreignId('statute_id')->nullable();

        $table->timestamps();
      });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mediations');
    }
};
