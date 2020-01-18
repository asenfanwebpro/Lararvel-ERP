<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoppingProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('product');
            $table->integer('categoryid')->nullable();
            $table->longtext('productdescription')->nullable();
            $table->float('cost', 8, 2)->nullable();
            $table->integer('brandid')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('shopping_product');
    }
}
