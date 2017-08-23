<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");                                         //场地名称
            $table->uuid("uid");                                            //唯一编号
            $table->integer("pid")->default(0);                             //父id
            $table->string("path");                                         //父级路径
            $table->string("remarks")->default("")->comment("场地备注信息"); //备注
            $table->integer('org_id')->default(0)->comment("所属公司");                   //公司id
            $table->softDeletes();
            $table->timestamps();
            $table->index(['name','pid']);
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
