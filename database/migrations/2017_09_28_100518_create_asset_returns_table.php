<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('return_code')->nullable()->comment("退库单号");          //退库单号
            $table->string("return_time")->nullable()->comment("退库时间");          //退库时间
//            $table->string("return_org_id")->nullable();     //退库后使用公司
//            $table->string("address_id")->nullable();        //退库后区域
//            $table->string("deposit_address")->nullable();   //退库后存放地点
            $table->string("asset_ids")->nullable()->comment("资产ID");             //资产物品
            $table->string("remarks")->nullable()->comment("备注说明");              //退库说明
            $table->string("return_dispose_user_id")->nullable();                   //退库处理人id
            $table->string("org_id")->nullable();                                   //当前公司id
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
        Schema::dropIfExists('asset_returns');
    }
}
