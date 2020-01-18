<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0);   //user super admin
            $table->string('name');
            $table->string('lastname',50)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('password_view')->nullable();
            $table->string('genere',1)->nullable();
            $table->date('datadinascita')->nullable();
            $table->string('codicefiscale',20)->nullable();
            $table->string('badge',15)->default('000000');
            $table->string('matricola',15)->default('0000.000000');
            $table->string('firma',50)->nullable();
            $table->string('sigla',50)->nullable();
            $table->string('avatar',100)->nullable();
            $table->string('ruolo',10)->default('user');
            $table->boolean('status')->default(1);
            $table->string('remember_token');
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
        Schema::dropIfExists('users');
    }
}
