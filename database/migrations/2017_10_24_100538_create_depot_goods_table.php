<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepotGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depot_goods', function (Blueprint $table) {
            $table->integer('depot_id')->unsigned();
            $table->integer('goods_id')->unsigned();
            $table->integer('goods_number')->nullable();
            $table->float('goods_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depot_goods');
    }
}
