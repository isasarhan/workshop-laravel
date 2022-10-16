<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('idea_title');
            $table->string('idea_description');
            $table->Integer('idea_chosen')->default(0);
            $table->bigInteger('idea_user_id')->unsigned()->nullable();
            $table->bigInteger('idea_workshop_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('idea_user_id')->references('id')->on('users');
            $table->foreign('idea_workshop_id')->references('id')->on('workshops');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ideas');
    }
}
