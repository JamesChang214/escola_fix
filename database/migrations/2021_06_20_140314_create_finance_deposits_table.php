<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('centre_id')->nullable()->constrained();
            $table->string('syear', 4)->nullable();
            $table->string('link_key', 100)->nullable();
            $table->string('link_id',11)->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->foreignId('payment_type_id')->nullable()->constrained();
            $table->date('deposited_date')->nullable();
            $table->string('deposited_by',50)->nullable();
            $table->string('description')->nullable();
            $table->string('status')->nullable();
            $table->tinyInteger('reconciled')->nullable();            
            $table->string('source')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finance_deposits');
    }
}
