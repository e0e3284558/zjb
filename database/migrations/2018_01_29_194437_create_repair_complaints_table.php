<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepairComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_complaints', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('process_id')->nullable()->comment('维修工单ID');
            $table->integer('service_worker_id')->nullable()->comment('维修人员ID');
            $table->integer('asset_id')->nullable()->comment('资产ID');
            $table->integer('classify_id')->nullable()->comment('分类ID');
            $table->string('complaints')->nullable()->comment('投诉内容');
            $table->integer('user_id')->nullable()->comment('投诉人');
            $table->string('admin_reply')->nullable()->comment('管理员回复');
            $table->string('process_result')->nullable()->comment('处理结果');
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
        Schema::dropIfExists('repair_complaints');
    }
}
