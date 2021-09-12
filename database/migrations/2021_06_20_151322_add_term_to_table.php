<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTermToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_fee_types', function (Blueprint $table) {
            $table->string('type',20)->after('usable_end_date')->nullable();
            $table->tinyInteger('is_enabled')->after('type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_fee_types', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('is_enabled');
        });
    }
}
