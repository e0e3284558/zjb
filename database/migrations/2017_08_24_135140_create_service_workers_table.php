<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_workers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('维修工姓名');
            $table->string('username')->nullable()->comment('维修工帐号');
            $table->string('password')->nullable()->comment('维修工密码');
            $table->integer('tel')->nullable()->comment('维修工手机号码');
            $table->integer('upload_id')->nullable()->comment('维修工照片');
            $table->string('comment')->nullable()->comment('维修工备注信息');
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
        Schema::dropIfExists('service_workers');
    }
}
