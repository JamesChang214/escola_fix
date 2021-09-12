<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAreaToSchools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('government_type')->after('type')->nullable();
            $table->string('school_code',10)->after('government_type')->nullable();
            $table->string('area')->after('school_code')->nullable();
            $table->string('affiliations')->after('area')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn('government_type');
            $table->dropColumn('school_code');
            $table->dropColumn('area');
            $table->dropColumn('affiliations');
        });
    }
}
