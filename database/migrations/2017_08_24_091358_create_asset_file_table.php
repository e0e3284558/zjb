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
        Schema::create('asset_file', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("asset_id")->default(0)->comment("资产id");                   //资产id
            $table->integer("file_id")->default(0)->comment("附件id");                    //附件id
            $table->integer('org_id')->default(0)->comment("所属公司");                   //公司id
            $table->softDeletes();
            $table->timestamps();
            $table->index(['org_id','asset_id','file_id']);
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
