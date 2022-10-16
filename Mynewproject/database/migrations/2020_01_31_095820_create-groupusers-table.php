<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupusersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupusers', function (Blueprint $table) {
            $table->bigInteger('groupuser_user_id')->unsigned()->nullable();
            $table->bigInteger('groupuser_group_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('groupuser_user_id')->references('id')->on('users');
            $table->foreign('groupuser_group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groupusers');
    }
}
