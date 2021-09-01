<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email');
            $table->string('password');
            $table->string('phone')->nullable();
            $table->integer('isActive')->nullable();
            $table->string('forgot_code')->nullable();
            $table->LongText('fcm_token')->nullable();
            $table->rememberToken();
            $table->bigInteger("role_id")->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');
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
        //
    }
}
