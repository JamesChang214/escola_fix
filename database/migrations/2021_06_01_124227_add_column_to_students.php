<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('display_name')->after('name_format')->nullable();
            $table->string('guardian2_first')->after('guardian1_display')->nullable();
            $table->string('guardian2_last')->after('guardian2_first')->nullable();
            $table->string('guardian2_common')->after('guardian2_last')->nullable();
            $table->string('guardian2_format',10)->after('guardian2_common')->nullable();
            $table->string('guardian2_display')->after('guardian2_format')->nullable();
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
            $table->dropColumn('display_name');
            $table->dropColumn('guardian2_first');
            $table->dropColumn('guardian2_last');
            $table->dropColumn('guardian2_common');
            $table->dropColumn('guardian2_format');
            $table->dropColumn('guardian2_display');
        });
    }
}
