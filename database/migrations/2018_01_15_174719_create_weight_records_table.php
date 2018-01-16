<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeightRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weight_records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('daily_log_id');
            $table->unsignedInteger('deck_id');
            $table->decimal('recorded_weight', 13, 2)->default(0);
            $table->decimal('optimal_weight', 13, 2)->default(0);
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
        Schema::dropIfExists('weight_records');
    }
}
