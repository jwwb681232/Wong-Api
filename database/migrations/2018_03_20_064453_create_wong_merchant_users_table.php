<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWongMerchantUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wong_merchant_users', function (Blueprint $table) {
            $table->increments('user_id')->comment('用户id');
            $table->string('user_name',32)->comment('用户名');
            $table->string('user_mobile',16)->default('')->comment('手机号码');
            $table->string('user_password',64)->comment('用户密码');
            $table->string('user_email',32)->default('')->comment('用户邮箱');
            $table->integer('user_add_time',false,true)->comment('注册时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wong_merchant_users');
    }
}
