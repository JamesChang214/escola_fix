<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->nullable()->constrained();
            $table->foreignId('student_id')->nullable()->constrained();
            $table->foreignId('invoice_fee_type_id')->nullable()->constrained('invoicefeetypes');
            $table->date('revenue_start_date')->nullable();
            $table->date('revenue_end_date')->nullable();
            $table->string('syear', 4)->nullable();
            $table->foreignId('classer_id')->nullable()->constrained();
            $table->string('description', 100)->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('tax', 10, 2)->nullable();
            $table->string('comment')->nullable();
            $table->integer('order')->nullable();
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
        Schema::dropIfExists('invoice_items');
    }
}
