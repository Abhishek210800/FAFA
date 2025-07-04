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
        Schema::table('mediator_mast', function (Blueprint $table) {
            $table->string('email')->unique()->nullable()->after('qualification'); // adjust position as needed
        });
    }

    public function down()
    {
        Schema::table('mediator_mast', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }

};
