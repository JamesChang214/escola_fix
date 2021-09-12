<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCentresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('centres', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('short_name', 50)->nullable();
            $table->string('2c_name', 2)->nullable();
            $table->string('regno', 50)->nullable();
            $table->date('fyending')->nullable();
            $table->string('address1', 100)->nullable();
            $table->string('address2', 100)->nullable();
            $table->string('address3', 100)->nullable();
            $table->string('address4', 100)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('postal_code', 50)->nullable();
            $table->string('area_code', 10)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('www', 50)->nullable();
            $table->string('contact', 100)->nullable();
            $table->string('calendar', 50)->nullable();
            $table->string('logo', 300)->nullable();
            $table->string('logo_small', 300)->nullable();
            $table->string('currency', 3)->nullable();
            $table->string('invoice_number_type', 10)->nullable();
            $table->string('invoice_number_format', 50)->nullable();
            $table->string('receipt_number_format', 50)->nullable();
            $table->string('invoice_template')->nullable();
            $table->string('receipt_template')->nullable();
            $table->string('contra_template')->nullable();
            $table->string('refund_template')->nullable();
            $table->text('payment_insturctions1')->nullable();
            $table->text('payment_instructions2')->nullable();
            $table->text('credit_instructions')->nullable();
            $table->integer('next_invoice_no')->nullable();
            $table->integer('next_adjustment_no')->nullable();
            $table->integer('next_receipt_no')->nullable();
            $table->integer('next_refund_no')->nullable();
            $table->integer('next_contra_no')->nullable();
            $table->integer('next_expense_no')->nullable();
            $table->integer('next_expense_payment_no')->nullable();
            $table->integer('next_claim_no')->nullable();
            $table->integer('next_journal_no')->nullable();
            $table->decimal('cash_on_hand', 10, 2)->nullable();
            $table->foreignId('created_user_id')->nullable()->constrained('users');
            $table->foreignId('edited_user_id')->nullable()->constrained('users');
            $table->foreignId('deleted_user_id')->nullable()->constrained('users');
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
        Schema::dropIfExists('centres');
    }
}
