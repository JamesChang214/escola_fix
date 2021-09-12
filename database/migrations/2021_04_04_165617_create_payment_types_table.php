<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('payment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('short_name', 20)->nullable();
            $table->string('syear', 4)->nullable();
            $table->foreignId('centre_id')->nullable()->constrained();
            $table->decimal('processing_fee', 10, 2)->nullable();
            $table->decimal('processing_percentage', 10, 2)->nullable();
            $table->string('is_usable')->nullable();
            $table->integer('account_id')->nullable();
            $table->boolean('globaluse')->nullable();
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
        Schema::dropIfExists('payment_types');
    }
}
