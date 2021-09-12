<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->nullable()->constrained();
            $table->foreignId('student_id')->nullable()->constrained();
            $table->foreignId('centre_id')->nullable()->constrained();
            $table->string('syear', 4)->nullable();
            $table->string('receipt_number')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->foreignId('payment_type_id')->nullable()->constrained();
            $table->text('private_note')->nullable();
            $table->text('public_note')->nullable();
            $table->string('cheuque_number', 128)->nullable();
            $table->string('bank_name', 128)->nullable();
            $table->string('cleared')->nullable();
            $table->date('cleared_date')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('status')->nullable();
            $table->string('source')->nullable();
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
        Schema::dropIfExists('invoice_payments');
    }
}
