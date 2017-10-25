<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('type')->nullable()->comment('单据类型');
            $table->string('delivery_number')->nullable()->comment('出库单号');
            $table->string('depot_id')->nullable()->comment('出库仓库');
            $table->dateTime('receipt_date')->nullable()->comment('出库日期');
            $table->dateTime('handle_date')->nullable()->comment('经办日期');
            $table->string('supplier')->nullable()->comment('供应商');
            $table->smallInteger('user_id')->nullable()->comment('经办人');
            $table->string('comment')->nullable()->comment('出库备注');
            $table->string('details')->nullable()->comment('出库详情id');
            $table->smallInteger('org_id')->nullable()->comment('公司id');
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
        Schema::dropIfExists('shipments');
    }
}
