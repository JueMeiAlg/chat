<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatMsgRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_msg_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('谁的记录');
            $table->integer('friend_id')->comment('那个好友发的');
            $table->text('msg')->comment('消息');
            $table->softDeletes();
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
        Schema::dropIfExists('chat_msg_records');
    }
}
