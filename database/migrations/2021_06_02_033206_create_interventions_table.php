<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterventionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->string('detail',750);
            $table->date('date');
            $table->time('hour');

            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('camera_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('camera_id')->references('id')->on('cameras')->onDelete('set null');

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
        Schema::dropIfExists('interventions');
    }
}
