<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetUsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_uses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable()->comment("领取单号");                        //领取单号
            $table->string('status')->nullable()->comment("领用状态");                        //领用状态
            $table->string("use_name")->nullable()->comment("领用人");                      //领用人
            $table->string("use_time")->nullable()->comment("领用时间");                    //领用时间
            $table->integer("use_department_id")->nullable("领用部门");                     //领用部门
            $table->string("expect_return_time")->nullable()->comment("预计退还时间");              //预计退还时间
            $table->string("return_time")->nullable()->comment("实际退还时间");              //实际退还时间
            $table->string("remarks")->nullable()->comment("备注说明");                     //说明
            $table->string("asset_ids")->nullable()->comment("资产物品id");                 //资产物品
            $table->integer("use_dispose_user_id")->nullable()->comment("领用处理人id");    //领用处理人id
            $table->integer("return_dispose_user_id")->nullable()->comment("退库处理人id"); //退库处理人id
            $table->integer("org_id");                                                      //当前公司id
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
        Schema::dropIfExists('asset_uses');
    }
}
