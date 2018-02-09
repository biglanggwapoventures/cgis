<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHarvestLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harvest_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('column_id');
            $table->unsignedInteger('harvest_id');
            $table->string('vehicle_plate_number', 20);
            $table->string('withdrawal_slip', 20);
            $table->unsignedInteger('farm_num_heads');
            $table->unsignedInteger('actual_num_heads');
            $table->decimal('farm_average_live_weight', 13, 3);
            $table->decimal('actual_average_live_weight', 13, 3);
            $table->unsignedInteger('doa_count');
            $table->timestamps();

            $table->foreign('harvest_id')->references('id')->on('harvests')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('column_id')->references('id')->on('columns')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('harvest_lines');
    }
}
