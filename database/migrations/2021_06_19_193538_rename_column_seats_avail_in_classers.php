<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnSeatsAvailInClassers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('classers', function (Blueprint $table) {
            $table->renameColumn('seats_avail', 'total_students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('classers', function (Blueprint $table) {
            $table->renameColumn('total_students', 'seats_avail');
        });
    }
}
