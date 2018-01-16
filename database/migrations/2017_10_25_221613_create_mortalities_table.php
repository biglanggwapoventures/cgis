<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMortalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mortalities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('daily_log_id')->nullable();
            $table->unsignedInteger('deck_id')->nullable();
            $table->unsignedInteger('num_am')->nullable();
            $table->unsignedInteger('num_pm')->nullable();
            $table->timestamps();

            $table->foreign('daily_log_id')->references('id')->on('daily_logs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('deck_id')->references('id')->on('decks')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mortalities');
    }
}
