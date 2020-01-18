<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mandati_invoice', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('mandati_id');
            $table->string('invoice_num');
            $table->date('voicedate');
            $table->float('voiceamount', 20, 2);
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
        Schema::dropIfExists('mandati_invoice');
    }
}
