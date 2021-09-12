<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsusableToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_types', function (Blueprint $table) {
            $table->boolean('is_usable_payments')->after('is_usable')->nullable();
            $table->boolean('is_usable_deposits')->after('is_usable_payments')->nullable();
            $table->boolean('is_usable_refunds')->after('is_usable_deposits')->nullable();
            $table->boolean('is_usable_pos')->after('is_usable_refunds')->nullable();
            $table->boolean('is_usable_pos_refunds')->after('is_usable_pos')->nullable();
            $table->boolean('is_usable_expenses')->after('is_usable_pos_refunds')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_types', function (Blueprint $table) {
            $table->dropColumn('is_usable_payments');
            $table->dropColumn('is_usable_deposits');
            $table->dropColumn('is_usable_refunds');
            $table->dropColumn('is_usable_pos');
            $table->dropColumn('is_usable_pos_refunds');
            $table->dropColumn('is_usable_expenses');
        });
    }
}
