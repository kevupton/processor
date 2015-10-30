<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_queue', function (Blueprint $table) {
            $table->increments('id');
            $table->string('package', 255);
            $table->text('data');
            $table->string('category', 64)->nullable();
            $table->datetime('exec_datetime');
            $table->timestamps();
        });

        Schema::create('process_log', function (Blueprint $table) {
            $table->increments('id');
            $table->text('process');
            $table->datetime('run_at');
            $table->boolean('completed');
            $table->string('error_message', 255)->nullable();
            $table->string('error_type', 255)->nullable();
            $table->bigInteger('runtime');
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
        Schema::dropIfExists('process_queue');
        Schema::dropIfExists('process_log');
    }
}
