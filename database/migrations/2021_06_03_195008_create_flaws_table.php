<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flaws', function (Blueprint $table) {
            $table->id();

            $table->date('dateflaw');
            $table->time('timeflaw');
            $table->string('description');

            $table->unsignedBigInteger('camera_id')->nullable();

            $table->date('datesolution')->nullable();;
            $table->time('timesolution')->nullable();;

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
        Schema::dropIfExists('flaws');
    }
}
