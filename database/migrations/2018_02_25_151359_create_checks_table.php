<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("admin_id")->nullable()->comment("管理员id");
            $table->integer("worker_id")->nullable()->comment("维修人员id");
            $table->integer("status")->default(0)->comment("点检状态 0|未分派 1|已分派未点检 2|已点检");
            $table->string("remarks")->nullable()->comment("点检结果描述");
            $table->string("asset_status")->nullable()->comment("点检资产情况 0|有问题,请求解决 1|检查正常 2|有问题已解决");
            $table->dateTime("check_time")->nullable();
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
        Schema::dropIfExists('checks');
    }
}
