<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('process_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("process_id")->nullable()->comment("维修工单id");
            $table->integer("service_worker_id")->nullable()->comment("维修人员id");
            $table->integer("up_id")->nullable()->comment("操作状态 1|待接单 2|已接单 3|拒绝接单 4|已完成 5|用户评价");
            $table->text("remarks")->nullable()->comment("维修日志描述");
            $table->integer("org_id")->nullable()->comment("所属公司id");
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
        Schema::dropIfExists('process_logs');
    }
}
