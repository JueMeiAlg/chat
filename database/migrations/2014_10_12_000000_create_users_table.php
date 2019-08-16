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
            $table->string('name');
            $table->string('password');
            $table->string('phone')->unique()->comment('用户手机号');
            $table->string('signature')->nullable()->comment('用户个性签名');
            $table->tinyInteger('status')->default(1)->comment('用户状态 1:正常 0封禁');
            $table->integer('fd')->unique()->nullable()->comment('wsk连接编号');
            $table->string('avatar')->nullable()->comment('用户头像');
            $table->string('token')->nullable()->comment('登录认证密匙');
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
