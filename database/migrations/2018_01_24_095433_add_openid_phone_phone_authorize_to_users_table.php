<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOpenidPhonePhoneAuthorizeToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('openid')->nullable()->comment('微信用户唯一识别号');
            $table->integer('phone')->nullable()->comment('微信用户绑定的手机号');
            $table->integer('phone_authorize')->nullable()->comment('微信用户手机号是否授权 0| 暂未授权 1| 已授权');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
