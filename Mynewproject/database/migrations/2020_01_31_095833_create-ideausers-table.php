<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdeausersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideausers', function (Blueprint $table) {
            $table->bigInteger('ideauser_user_id')->unsigned()->nullable();
            $table->bigInteger('ideauser_idea_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('ideauser_user_id')->references('id')->on('users');
            $table->foreign('ideauser_idea_id')->references('id')->on('ideas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ideausers');
    }
}
