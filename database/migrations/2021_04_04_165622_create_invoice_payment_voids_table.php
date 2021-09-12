<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicePaymentVoidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('invoice_payment_voids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_payment_id')->nullable()->constrained();
            $table->string('reason')->nullable();
            $table->date('voided_date')->nullable();
            $table->unsignedBigInteger('volided_by')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_payment_voids');
    }
}
