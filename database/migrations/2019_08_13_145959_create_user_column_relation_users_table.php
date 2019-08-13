<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserColumnRelationUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_column_relation_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment('用户Id');
            $table->integer('column_id')->comment('栏目Id');
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
        Schema::dropIfExists('user_cloumn_relation_users');
    }
}
