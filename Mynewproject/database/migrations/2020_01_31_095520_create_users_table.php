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
            $table->bigIncrements('id');
            $table->string('user_first_name');
            $table->string('user_last_name');
            $table->string('email',100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->Integer('user_chosen')->default(0);
            $table->bigInteger('user_level_id')->unsigned()->nullable();
            $table->bigInteger('user_status_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('user_level_id')->references('id')->on('levels');
            $table->foreign('user_status_id')->references('id')->on('statuses');
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
