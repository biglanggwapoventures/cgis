<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('causer_type');
            $table->unsignedInteger('causer_id');
            $table->unsignedInteger('feed_id');
            $table->unsignedInteger('daily_log_id');
            $table->decimal('quantity');
            $table->decimal('balance');
            $table->timestamps();

            $table->foreign('feed_id')->references('id')->on('feeds')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('daily_log_id')->references('id')->on('daily_logs')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feed_logs');
    }
}
