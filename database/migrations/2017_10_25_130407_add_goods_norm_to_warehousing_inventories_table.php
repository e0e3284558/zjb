<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGoodsNormToWarehousingInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehousing_inventories', function (Blueprint $table) {
            $table->string('goods_coding')->nullable()->comment('物品编码');

            $table->string('goods_norm')->nullable()->comment('物品规格');
            $table->string('goods_unit')->nullable()->comment('物品单位');
            $table->double('goods_unit_price')->nullable()->comment('物品单价');
            $table->double('goods_total_price')->nullable()->comment('物品总价');
            $table->string('comment')->nullable()->comment('备注');
            $table->dropIndex(['goods_id']);//删除索引
            $table->string('goods_name')->nullable()->comment('物品名称')->change();
            $table->string('goods_num')->nullable()->comment('物品数量')->change();
            $table->string('goods_code')->nullable()->comment('物品编码')->change();
            $table->string('goods_barcode')->nullable()->comment('物品条码')->change();
            $table->integer('org_id')->nullable()->comment('对应公司')->change();
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
