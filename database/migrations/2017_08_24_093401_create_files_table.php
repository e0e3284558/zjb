<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string("type")->comment("文件类型");                     //文件类型
            $table->string("name");                                         //名称
            $table->string("old_name")->comment("文件原始名称");             //原名称
            $table->integer("width")->default(0);                           //宽
            $table->integer("height")->default(0);                          //高
            $table->string("suffix")->comment("文件后缀名");                 //后缀名
            $table->string("file_path")->comment("文件存储路径");            //存储路径
            $table->string("path")->comment("文件所在路径");                 //路径
            $table->integer("size")->default(0)->comment("文件大小");        //文件大小
            $table->integer("org_id")->default(0)->comment("所属公司");      //所属公司
            $table->softDeletes();
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
        Schema::dropIfExists('files');
    }
}
