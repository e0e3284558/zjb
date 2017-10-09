<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coding')->nullable()->comment('物品编码');
            $table->string('name')->nullable()->comment('物品名称');
            $table->integer('classify_id')->nullable()->comment('所属分类');
            $table->string('barcode')->nullable()->comment('物品条形码');
            $table->string('norm')->nullable()->comment('规格型号');
            $table->string('unit')->nullable()->comment('单位');
            $table->string('trademark')->nullable()->comment('商标');
            $table->smallInteger('inventory_cap')->default(100)->comment('安全库存上限');
            $table->smallInteger('inventory_lower')->default(0)->comment('安全库存下限');
            $table->boolean('disable')->default(0)->comment('是否禁用');
            $table->string('comment')->default(1)->comment('备注');
            $table->string('upload_id')->nullable()->comment('图片');
            $table->string('org_id')->nullable()->comment('所属公司');
            $table->string('user_id')->nullable()->comment('操作员');
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
        Schema::dropIfExists('goods');
    }
}
