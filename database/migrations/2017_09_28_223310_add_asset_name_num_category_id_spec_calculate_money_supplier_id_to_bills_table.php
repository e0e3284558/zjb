<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssetNameNumCategoryIdSpecCalculateMoneySupplierIdToBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bills', function (Blueprint $table) {
            $table->string('asset_name')->nullable()->comment('资产名字');
            $table->integer('num')->nullable()->comment('资产数量');
            $table->integer('category_id')->nullable()->comment('资产类别id');
            $table->string('spec')->nullable()->comment('规格型号');
            $table->string('calculate')->nullable()->comment('计量单位');
            $table->string('money')->nullable()->comment('单价');
            $table->integer('supplier_id')->nullable()->comment('供应商id');
            $table->integer('status')->nullable()->comment('是否录入资产状态值  1未录入  2已录入');
            //删除字段
            $table->dropColumn(['name']);
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
