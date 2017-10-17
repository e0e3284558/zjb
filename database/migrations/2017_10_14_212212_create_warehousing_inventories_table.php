<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehousingInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehousing_inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('foods_id')->unique()->comment('物品id');
            $table->string('foods_name')->comment('物品名称');
            $table->string('foods_num')->comment('物品数量');
            $table->string('foods_code')->comment('物品编码');
            $table->string('foods_barcode')->comment('物品条码');
            $table->integer('org_id')->comment('对应公司');
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
        Schema::dropIfExists('warehousing_inventories');
    }
}
