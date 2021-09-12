<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 30)->nullable();
            $table->foreignId('centre_id')->nullable()->constrained();
            $table->foreignId('student_id')->nullable()->constrained();
            $table->string('syear', 4)->nullable();
            $table->date('revenue_start_date')->nullable();
            $table->date('revenue_end_date')->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('adjustment', 10, 2)->nullable();
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('balance', 10, 2)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('address1', 100)->nullable();
            $table->string('address2', 100)->nullable();
            $table->string('address3', 100)->nullable();
            $table->string('address4', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->date('printed_date')->nullable();
            $table->date('emailed_date')->nullable();
            $table->text('instructions_1')->nullable();
            $table->text('instructions_2')->nullable();
            $table->text('instructions_3')->nullable();
            $table->text('instructions_4')->nullable();
            $table->text('invoice_header')->nullable();
            $table->string('invoice_footer', 100)->nullable();
            $table->string('invoice_template')->nullable();
            $table->string('private_note')->nullable();
            $table->string('public_note')->nullable();
            $table->string('status', 20)->nullable();
            $table->string('source', 20)->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
