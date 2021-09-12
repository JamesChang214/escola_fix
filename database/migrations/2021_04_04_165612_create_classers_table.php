<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('classers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classertemplate_id')->nullable()->constrained();
            $table->foreignId('centre_id')->nullable()->constrained();
            $table->string('name', 50)->nullable();
            $table->string('short_name', 20)->nullable();
            $table->string('subject', 50)->nullable();
            $table->foreignId('grade_id')->nullable()->constrained();
            $table->string('syear', 4)->nullable();
            $table->foreignId('period_id')->nullable()->constrained();
            $table->string('location', 1)->nullable();
            $table->string('days', 1)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('credits')->nullable();
            $table->integer('seats')->nullable();
            $table->integer('seats_avail')->nullable();
            $table->boolean('graded')->nullable();
            $table->boolean('attendance')->nullable();
            $table->boolean('published')->nullable();
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
        Schema::dropIfExists('classers');
    }
}
