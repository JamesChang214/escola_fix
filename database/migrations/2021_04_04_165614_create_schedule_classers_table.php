<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleClassersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('schedule_classers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->constrained();
            $table->foreignId('classer_id')->nullable()->constrained();
            $table->date('enrollment_date')->nullable()->nullable();
            $table->date('withdrawl_date')->nullable()->nullable();
            $table->string('reason', 30)->nullable();
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
        Schema::dropIfExists('schedule_classers');
    }
}
