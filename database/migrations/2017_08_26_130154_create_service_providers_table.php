<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('服务商名称');
            $table->text('comment')->nullable()->comment('服务商简介');
            $table->string('user')->nullable()->comment('服务商负责人');
            $table->string('tel')->nullable()->comment('服务商联系电话');
            $table->integer('logo_id')->nullable()->comment('logo');
            $table->integer('upload_id')->nullable()->comment('上传附件');
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
        Schema::dropIfExists('service_providers');
    }
}
