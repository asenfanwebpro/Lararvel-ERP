<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_order', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('companyid');
            $table->integer('supplierid');
            $table->integer('anno');
            $table->integer('no');
            $table->string('fname')->nullable();
            $table->string('mnumber')->nullable();
            $table->string('aptnumber')->nullable();
            $table->string('landmark')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();
            $table->string('state')->nullable();
            $table->string('payment')->nullable();
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
        Schema::dropIfExists('shopping_order');
    }
}
