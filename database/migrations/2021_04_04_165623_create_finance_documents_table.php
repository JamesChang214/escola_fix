<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinanceDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('finance_documents', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->integer('link_key')->nullable();
            $table->integer('link_id')->nullable();
            $table->foreignId('centre_id')->nullable()->constrained();
            $table->string('syear', 4)->nullable();
            $table->integer('vendor_id')->nullable();
            $table->foreignId('student_id')->nullable()->constrained();
            $table->string('document_no')->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('tax_amount', 10, 2)->nullable();
            $table->decimal('total_discount_amount', 10, 2)->nullable();
            $table->decimal('total_tax_amount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->string('reason')->nullable();
            $table->string('source')->nullable();
            $table->string('status')->nullable();
            $table->string('transaction_payee')->nullable();
            $table->integer('transaction_type_id')->nullable();
            $table->string('transaction_doc_no')->nullable();
            $table->date('transaction_date')->nullable();
            $table->text('private_note')->nullable();
            $table->text('public_note')->nullable();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->dateTime('cleared_date')->nullable();
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
        Schema::dropIfExists('finance_documents');
    }
}
