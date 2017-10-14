<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetClearsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_clears', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->nullable()->comment("清理单号");
            $table->string('serial_number')->nullable()->comment("序列号");
            $table->string('clear_time')->nullable()->comment("清理日期");
            $table->integer('user_id')->nullable()->comment("清理处理人");
            $table->string('asset_ids')->nullable()->comment("清理资产");
            $table->string('remarks')->nullable()->comment('清理说明');
            $table->integer('org_id')->nullable()->comment('公司id');
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
        Schema::dropIfExists('asset_clears');
    }
}
