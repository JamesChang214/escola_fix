<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassertemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('classertemplates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('subject', 100)->nullable();
            $table->string('course', 100)->nullable();
            $table->foreignId('grade_id')->nullable()->constrained();
            $table->integer('seats')->nullable();
            $table->string('period', 50)->nullable();
            $table->boolean('graded')->nullable();
            $table->boolean('published')->nullable();
            $table->boolean('attendance')->nullable();
            $table->string('location', 20)->nullable();
            $table->integer('credits')->nullable();
            $table->string('format', 20)->nullable();
            $table->string('syear', 4)->nullable();
            $table->decimal('lesson_price', 10, 2)->nullable();
            $table->decimal('material', 10, 2)->nullable();
            $table->decimal('registration', 10, 2)->nullable();
            $table->string('globaluse')->nullable();
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
        Schema::dropIfExists('classertemplates');
    }
}
