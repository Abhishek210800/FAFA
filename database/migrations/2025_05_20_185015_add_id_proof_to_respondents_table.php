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
        Schema::table('respondents', function (Blueprint $table) {
            $table->string('id_proof')->nullable()->after('email');
        });
    }

    public function down()
    {
        Schema::table('respondents', function (Blueprint $table) {
            $table->dropColumn('id_proof');
        });
    }

};
