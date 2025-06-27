<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameDefendantIdProofColumnInMediationsTable extends Migration
{
    public function up()
    {
        Schema::table('mediations', function (Blueprint $table) {
            $table->renameColumn('defendant_id_proof', 'defandant_id_proof');
        });
    }

    public function down()
    {
        Schema::table('mediations', function (Blueprint $table) {
            $table->renameColumn('defandant_id_proof', 'defendant_id_proof');
        });
    }
}
