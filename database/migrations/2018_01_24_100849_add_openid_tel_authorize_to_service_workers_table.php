<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOpenidTelAuthorizeToServiceWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_workers', function (Blueprint $table) {
            $table->string('openid')->nullable()->comment('微信用户唯一识别号');
            $table->integer('tel_authorize')->nullable()->comment('微信用户手机号是否授权 0| 暂未授权 1| 已授权');
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
