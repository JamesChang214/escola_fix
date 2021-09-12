<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->boolean('multiple_school')->nullable();
            $table->string('short_name', 50)->nullable();
            $table->string('syear', 4)->nullable();
            $table->string('time_start', 5)->nullable();
            $table->string('time_end', 5)->nullable();
            $table->string('duration', 5)->nullable();
            $table->integer('order')->nullable();
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
        Schema::dropIfExists('profiles');
    }
}
