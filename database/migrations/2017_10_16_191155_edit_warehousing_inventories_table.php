<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditWarehousingInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('warehousing_inventories', function (Blueprint $table) {
            $table->renameColumn('foods_id', 'goods_id');
            $table->renameColumn('foods_name', 'goods_name');
            $table->renameColumn('foods_num', 'goods_num');
            $table->renameColumn('foods_code', 'goods_code');
            $table->renameColumn('foods_barcode', 'goods_barcode');
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
