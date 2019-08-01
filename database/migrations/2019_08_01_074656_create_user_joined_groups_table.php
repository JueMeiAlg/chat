<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserJoinedGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_joined_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('group_id')->comment('群组Id');
            $table->integer('user_id')->comment('用户Id');
            $table->timestamps();
            //联合唯一键,一个用户只能加入一次群组
            $table->unique(['group_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_joined_groups');
    }
}
