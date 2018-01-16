<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedsConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds_consumptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('daily_log_id')->nullable();
            $table->unsignedInteger('deck_id')->nullable();
            $table->unsignedInteger('feed_id')->nullable();
            $table->decimal('num_feed', 13, 2)->nullable();
            $table->timestamps();

            $table->foreign('daily_log_id')->references('id')->on('daily_logs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('deck_id')->references('id')->on('decks')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('feed_id')->references('id')->on('feeds')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feeds_consumptions');
    }
}
