<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToStudentscontact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('guardian1_phone')->after('guardian1_display')->nullable();
            $table->string('guardian1_email')->after('guardian1_phone')->nullable();
            $table->string('guardian2_phone')->after('guardian2_display')->nullable();
            $table->string('guardian2_email')->after('guardian2_phone')->nullable();
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
            $table->dropColumn('guardian1_email');
            $table->dropColumn('guardian1_phone');
            $table->dropColumn('guardian2_email');
            $table->dropColumn('guardian2_phone');

        });
    }
}
