<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50)->nullable();
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('common_name', 50)->nullable();
            $table->string('name_format', 10)->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('ethnicity', 20)->nullable();
            $table->string('language', 20)->nullable();
            $table->string('identification')->nullable();
            $table->foreignId('school_id')->nullable()->constrained();
            $table->string('address1', 100)->nullable();
            $table->string('address2', 100)->nullable();
            $table->string('address3', 100)->nullable();
            $table->string('address4', 100)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('postal_code', 50)->nullable();
            $table->string('area_code', 10)->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('avatar')->nullable();
            $table->date('enrollment_date')->nullable();
            $table->string('source')->nullable();
            $table->foreignId('grade_id')->nullable()->constrained();
            $table->string('status', 20)->nullable();
            $table->foreignId('centre_id')->nullable()->constrained();
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
        Schema::dropIfExists('students');
    }
}
