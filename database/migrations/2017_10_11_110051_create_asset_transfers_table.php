<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status')->nullable()->comment(" 1 已调出 2 已完成 3 已取消");     //状态
            $table->string('out_time')->nullable()->comment("调出日期");                     //调出日期
            $table->integer("out_admin_id")->nullable()->comment("调出管理员");               //调出管理员
            $table->string("out_remarks")->nullable()->comment('调出说明');                  //调出说明
            $table->string("put_time")->nullable()->comment("调入日期");                     //调入日期
            $table->integer("put_admin_id")->nullable()->comment("调入管理员");               //调入管理员
            $table->integer("put_department_id")->nullable()->comment('调入部门');               //调入部门
            $table->integer("put_area_id")->nullable()->comment('调入场地');               //调入场地
            $table->string("put_remarks")->nullable()->comment('调入说明');                  //调入说明
            $table->string("transfer_time")->nullable()->comment('调拨单处理日期');           //调拨单处理日期
            $table->integer("asset_id")->nullable()->comment('调拨资产');                    //调拨资产
            $table->integer("org_id");                                                       //当前所属公司
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
        Schema::dropIfExists('asset_transfers');
    }
}
