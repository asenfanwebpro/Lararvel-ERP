<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartureinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departure_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('departure_id')->default(0);
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->string('type',100)->default('note');
            $table->longText('text');
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('departure_info');
    }
}
