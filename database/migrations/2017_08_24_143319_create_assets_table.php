<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string("code")->default('0');                                           //资产编号
            $table->string("name");                                                         //场地名称
            $table->uuid("asset_uid")->comment('资产唯一识别码');                            //资产唯一识别码
            $table->integer("category_id")->default(0);                                      //资产类别
            $table->string("spec")->nullable()->comment('规格型号');                        //规格型号
            $table->string("SN_code")->nullable()->comment('SN号');                         //SN号
            $table->string("calculate")->nullable()->comment('计量单位');                  //计量单位
            $table->string("money")->nullable()->comment('金额');                           //金额
            $table->integer("use_department_id")->nullable()->comment("使用部门");            //使用部门
            $table->date("buy_time")->comment('购入时间 ');                                   //购入时间
            $table->string("user_name")->nullable()->comment('使用者');                        //使用者
            $table->integer("admin_id")->default(0);                                           //管理员
            $table->integer("area_id")->default(0)->comment("所在位置");                                    //所在位置
            $table->string("use_time")->nullable()->comment("使用年限");                    //使用期限
            $table->string("supplier")->nullable()->comment('供应商');                       //供应商
            $table->string("source_id")->default('1')->comment('来源');                       //来源
            $table->string("remarks")->nullable()->comment('备注');                          //备注
            $table->integer('org_id')->default(0)->comment("所属公司");                        //公司id
            $table->integer('department_id')->default(0)->comment('所属部门');
            $table->integer("asset_status_id")->default(1)->comment("资产状态");              //物品状态
            $table->softDeletes();
            $table->timestamps();
            $table->index(['name','asset_uid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assets');
    }
}
