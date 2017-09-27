<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('borrow_status')->comment("借用状态");                        //借用状态
            $table->string('borrow_articles_id')->comment("借用资产的id");                   //借用资产
            $table->string("borrow_code")->comment("借用单号");                          //借用单号
            $table->string("borrow_time")->nullable()->comment("借用时间");                          //借用时间
            $table->string("borrow_user_name")->comment("借用人");                     //借用人
            $table->string("expect_return_time")->nullable()->comment("预计归还时间");      //预计归还时间
            $table->string("return_time")->nullable()->comment("真实归还时间");             //真实归还时间
            $table->integer("borrow_handle_user_id")->comment("借用处理人");                //借用处理人
            $table->integer("return_handle_user_id")->comment("归还处理人");                //归还处理人
            $table->string("remarks")->nullable()->comment("备注");                   //备注
            $table->integer("org_id");                               //当前公司id
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
        Schema::dropIfExists('borrows');
    }
}
