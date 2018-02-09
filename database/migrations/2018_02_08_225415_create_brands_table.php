<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name")->nullable()->commit("品牌名称");
            $table->uuid("uuid")->nullable()->commit("品牌唯一标识");
            $table->integer("pid")->default(0)->commit("父级id");
            $table->string("path")->nullable()->commit("品牌层级路径");
            $table->string("remarks")->nullable()->commit("备注信息");
            $table->string("code")->nullable()->commit("品牌编码");
            $table->string("qrcode_path")->nullable()->commit("二维码保存路径");
            $table->integer("org_id")->nullable()->commit("所属公司");
            $table->integer("status")->default(1)->commit("品牌状态 0:不可用 1:可用");
            $table->softDeletes();
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
        Schema::dropIfExists('brands');
    }
}
