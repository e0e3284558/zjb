<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehousingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehousings', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('type')->comment('单据类型');
            $table->string('receipt_number')->comment('入库单号');
            $table->string('delivery_number')->comment('出库单号');
            $table->string('depot_id')->comment('入库仓库');
            $table->dateTime('receipt_date')->comment('入库日期');
            $table->dateTime('handle_date')->comment('经办日期');
            $table->string('supplier')->comment('供应商');
            $table->smallInteger('user_id')->comment('经办人');
            $table->string('comment')->comment('入库备注');
            $table->string('details')->default('')->comment('入库详情id');
            $table->smallInteger('org_id')->comment('公司id');
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
        Schema::dropIfExists('warehousings');
    }
}
