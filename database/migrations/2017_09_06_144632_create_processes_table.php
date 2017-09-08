<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('org_id')->nullable()->comment('公司id');
            $table->integer('user_id')->nullable()->comment('报修人ID');
            $table->integer('admin_id')->nullable()->comment('管理员id');
            $table->integer('asset_id')->nullable()->comment('资产id');
            $table->integer('asset_classify_id')->nullable()->comment('资产分类id');
            $table->integer('service_worker_id')->nullable()->comment('维修工id');
            $table->integer('service_provider_id')->nullable()->comment('服务商id');
            $table->string('remarks')->nullable()->comment('用户备注信息');
            $table->string('suggest')->nullable()->comment('首次未修好，提供的维修建议');
            $table->string('appraisal')->nullable()->comment('用户评价');
            $table->string('score')->nullable()->comment('用户评分');
            $table->integer('status')->nullable()->comment('状态，1|已填写报修信息。2|手动分工。3|自动分工。4|维修工确认接单。0|资产报废不可再修。10|已修好');
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
        Schema::dropIfExists('processes');
    }
}
