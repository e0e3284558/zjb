<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefuseRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('refuse_repairs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('process_id')->nullable()->comment('维修工单ID');
            $table->integer('service_worker_id')->nullable()->comment('维修人员ID');
            $table->integer('asset_id')->nullable()->comment('资产ID');
            $table->string('order_reason')->nullable()->comment('拒单理由');
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
        Schema::table('refuse_repairs', function (Blueprint $table) {
            //
        });
    }
}
