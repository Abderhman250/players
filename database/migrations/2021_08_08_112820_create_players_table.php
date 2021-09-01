<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('nickname');
            $table->string('gender');
            $table->string('profile_picture')->nullable();
            $table->string('birthday');
            $table->double('height');
            $table->double('weight');
            $table->string('position');
            $table->enum('footPlay',array('left', 'right'));
            $table->string('living_location');
            $table->string('previous_clubs');
            $table->string('current_club');
            

            $table->string('number_goals');
            $table->string('number_matches');
            $table->string('player_location');
            $table->string('strength_point');
            $table->string('scientificl_level');
            $table->string('level');
            $table->text('skills')->nullable();
            $table->bigInteger("user_id")->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('players');
    }
}
