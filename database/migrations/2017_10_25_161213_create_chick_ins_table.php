<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChickInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chick_ins', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('grow_id')->nullable();
            $table->unsignedInteger('column_id')->nullable();
            $table->unsignedInteger('num_heads')->nullable();
            $table->unsignedInteger('num_dead')->nullable();
            $table->date('chick_in_date')->nullable();
            $table->string('reference_number', 20)->nullable();
            $table->timestamps();

            $table->foreign('grow_id')->references('id')->on('grows')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('chick_ins');
    }
}
