<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkshopusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshopusers', function (Blueprint $table) {
            $table->bigInteger('workshopuser_user_id')->unsigned()->nullable();
            $table->bigInteger('workshopuser_workshop_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('workshopuser_user_id')->references('id')->on('users');
            $table->foreign('workshopuser_workshop_id')->references('id')->on('workshops');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workshopusers');
    }
}
