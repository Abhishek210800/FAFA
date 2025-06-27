<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mediations', function (Blueprint $table) {
            $table->longText('case_summary')->nullable();
        });
    }

    public function down()
    {
        Schema::table('mediations', function (Blueprint $table) {
            $table->dropColumn('case_summary');
        });
    }

};
