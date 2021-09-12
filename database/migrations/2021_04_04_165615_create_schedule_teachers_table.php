<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('schedule_teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classer_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable()->nullable();
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
        Schema::dropIfExists('schedule_teachers');
    }
}
