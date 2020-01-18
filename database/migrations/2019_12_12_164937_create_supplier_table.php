<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('societa_fornitori', function (Blueprint $table) {
            $table->bigIncrements('id');           
            $table->string('name',50);
            $table->string('citta',50)->nullable();
            $table->string('indirizzo',250)->nullable();
            $table->integer('cap')->nullable();
            $table->string('iva',15)->nullable();
            $table->string('cf',25)->nullable();
            $table->string('sdi',10)->nullable();
            $table->string('mail',100)->nullable();
            $table->string('pec',100)->nullable();
            $table->string('tel',20)->nullable();
            $table->string('fax',20)->nullable();
            $table->string('web',191)->nullable();
            $table->string('firma',200)->nullable();
            $table->string('logo',200)->nullable();
            $table->string('info_termini')->nullable();  
            $table->string('category')->nullable();            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('societa_fornitori');
    }
}
