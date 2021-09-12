<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceFeeTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('invoice_fee_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('short_name', 20)->nullable();
            $table->string('syear', 4)->nullable();
            $table->foreignId('grade_id')->nullable()->constrained();
            $table->integer('sort_order')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->boolean('taxable')->nullable();
            $table->integer('tax_percentage')->nullable();
            $table->date('revenue_start_date')->nullable();
            $table->date('revenue_end_date')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('usable_start_date')->nullable();
            $table->date('usable_end_date')->nullable();
            $table->boolean('globaluse')->nullable();
            $table->string('is_usable')->nullable();
            $table->boolean('is_refundable')->nullable();
            $table->integer('account_id')->nullable();
            $table->text('payment_instructions')->nullable();
            $table->text('small_print')->nullable();
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
        Schema::dropIfExists('invoice_fee_types');
    }
}
