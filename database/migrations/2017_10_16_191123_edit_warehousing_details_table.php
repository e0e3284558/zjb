<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditWarehousingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehousing_details', function (Blueprint $table) {
            $table->renameColumn('foods_id', 'goods_id');
            $table->renameColumn('foods_name', 'goods_name');
            $table->renameColumn('foods_coding', 'goods_coding');
            $table->renameColumn('foods_barcode', 'goods_barcode');
            $table->renameColumn('foods_norm', 'goods_norm');
            $table->renameColumn('foods_unit', 'goods_unit');
            $table->renameColumn('foods_batch', 'goods_batch');
            $table->renameColumn('foods_num', 'goods_num');
            $table->renameColumn('foods_unit_price', 'goods_unit_price');
            $table->renameColumn('foods_total_price', 'goods_total_price');
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
