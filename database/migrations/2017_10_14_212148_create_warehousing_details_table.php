<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehousingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehousing_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('foods_id')->comment('对应物品ID');
            $table->string('foods_name')->comment('对应物品名称');
            $table->string('foods_coding')->comment('物品编码');
            $table->string('foods_barcode')->comment('物品条码');
            $table->string('foods_norm')->comment('物品规格型号');
            $table->string('foods_unit')->comment('物品单位');
            $table->integer('foods_batch')->comment('物品批次');
            $table->smallInteger('foods_num')->comment('入库数量');
            $table->integer('foods_unit_price')->comment('入库单价');
            $table->integer('foods_total_price')->comment('入库总价');
            $table->string('comment')->comment('备注');
            $table->integer('org_id');
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
        Schema::dropIfExists('warehousing_details');
    }
}
