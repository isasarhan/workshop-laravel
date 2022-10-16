<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdeagradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideagrades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('ideagrade_idea_id')->unsigned()->nullable();
            $table->bigInteger('ideagrade_grade_value');
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('ideagrade_idea_id')->references('id')->on('ideas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ideagrades');
    }
}
