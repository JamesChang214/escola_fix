<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('periods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('short_name', 50);
            $table->string('syear', 4);
            $table->string('time_start', 5);
            $table->string('time_end', 5);
            $table->string('duration', 5);
            $table->integer('order')->nullable();
            $table->boolean('globaluse');
            $table->boolean('published');
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
        Schema::dropIfExists('periods');
    }
}
