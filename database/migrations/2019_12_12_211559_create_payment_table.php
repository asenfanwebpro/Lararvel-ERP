<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mandati_payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mandati_id');
            $table->string('method');
            $table->date('paydate');
            $table->string('transaction');
            $table->float('payamount', 20, 2);     
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
        Schema::dropIfExists('mandati_payment');
    }
}
