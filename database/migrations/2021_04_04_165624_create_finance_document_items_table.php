<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceDocumentItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('finance_document_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('finance_document_id')->nullable()->constrained();
            $table->integer('link_key')->nullable();
            $table->integer('link_id')->nullable();
            $table->foreignId('classer_id')->nullable()->constrained();
            $table->decimal('amount', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->string('description')->nullable();
            $table->date('transaction_date')->nullable();
            $table->string('reference_no')->nullable();
            $table->text('private_note')->nullable();
            $table->text('public_note')->nullable();
            $table->integer('account_id')->nullable();
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
        Schema::dropIfExists('finance_document_items');
    }
}
