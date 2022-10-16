<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('workshop_title');
            $table->string('workshop_key');
            $table->string('workshop_question')->nullable();
            $table->Integer('workshop_nb_of_participants');
            $table->Integer('workshop_stage')->default(0);
            $table->Integer('workshop_status')->default(0);
            $table->Integer('workshop_switch')->default(0);
            $table->bigInteger('workshop_user_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('workshop_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workshops');
    }
}
