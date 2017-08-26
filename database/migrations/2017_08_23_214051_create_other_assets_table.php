<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string("code")->default('0');                                        //其他资产编号
            $table->string("name");                                                     //场地名称
            $table->uuid("uid");                                                        //唯一识别号
            $table->string("category_id")->default(0);                                  //资产类别
            $table->string("remarks")->nullable();                                     //备注
            $table->integer('org_id')->default(0)->comment("所属公司");                  //公司id
            $table->softDeletes();
            $table->timestamps();
            $table->index(['name','uid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
