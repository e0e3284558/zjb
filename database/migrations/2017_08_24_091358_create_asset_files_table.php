<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("asset_id")->default(0);                                     //资产id
            $table->integer("file_id")->default(0);                                      //附件id
            $table->integer('org_id')->default(0)->comment("所属公司");                   //公司id
            $table->softDeletes();
            $table->timestamps();
            $table->index(['name','uid']);
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
