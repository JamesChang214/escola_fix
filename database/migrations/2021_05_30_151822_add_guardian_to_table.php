<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuardianToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('guardian1_first')->after('school_id')->nullable();
            $table->string('guardian1_last')->after('guardian1_first')->nullable();
            $table->string('guardian1_common')->after('guardian1_last')->nullable();
            $table->string('guardian1_format',10)->after('guardian1_common')->nullable();
            $table->string('guardian1_display')->after('guardian1_format')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('guardian1_first');
            $table->dropColumn('guardian1_last');
            $table->dropColumn('guardian1_common');
            $table->dropColumn('guardian1_format');
            $table->dropColumn('guardian1_display');
        });
    }
}
