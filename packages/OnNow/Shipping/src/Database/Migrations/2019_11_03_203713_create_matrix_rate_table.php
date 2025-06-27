<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatrixRateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matrix_rates', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id')->nullable();
            $table->unsignedInteger('country_state_id')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code_from')->nullable();
            $table->string('zip_code_to')->nullable();
            $table->decimal('weight_from', 10, 4);
            $table->decimal('weight_to', 10, 4);
            $table->decimal('value', 10, 4);
            $table->string('description');
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('country_state_id')->references('id')->on('country_states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matrix_rates');
    }
}
