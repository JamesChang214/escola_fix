<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('short_name', 20)->nullable();
            $table->string('name')->nullable();
            $table->string('course')->nullable();
            $table->string('level')->nullable();
            $table->string('certificate')->nullable();
            $table->string('type')->nullable();
            $table->foreignId('prerequisite')->nullable()->constrained('lessons');
            $table->foreignId('combined')->nullable()->constrained('lessons');
            $table->string('complexity', 20)->nullable();
            $table->integer('lft')->nullable();
            $table->integer('rgt')->nullable();
            $table->integer('depth')->nullable();
            $table->integer('min_age')->nullable();
            $table->tinyInteger('online')->nullable();
            $table->string('source', 20)->nullable();
            $table->string('version', 10)->nullable();
            $table->string('year', 4)->nullable();
            $table->string('categiory', 20)->nullable();
            $table->string('tags')->nullable();
            $table->tinyInteger('published')->nullable();
            $table->tinyInteger('global')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
}
