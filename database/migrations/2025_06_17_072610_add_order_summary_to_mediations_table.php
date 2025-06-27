<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOrderSummaryToMediationsTable extends Migration
{
    public function up()
    {
        Schema::table('mediations', function (Blueprint $table) {
            $table->text('order_summary')->nullable()->after('order_file');
        });
    }

    public function down()
    {
        Schema::table('mediations', function (Blueprint $table) {
            $table->dropColumn('order_summary');
        });
    }
}
