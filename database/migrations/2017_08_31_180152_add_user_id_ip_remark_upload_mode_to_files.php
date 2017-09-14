<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdIpRemarkUploadModeToFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->ipAddress('ip')->nullable()->comment('上传ip')->index();
            $table->integer('user_id')->default(0)->comment('上传用户id')->index();
            $table->string('remark')->nullable()->comment('文件描述');
            $table->string('upload_mode')->nullable()->comment('上传模式：file:文件上传image上传video视频上传');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn('ip');
            $table->dropColumn('user_id');
            $table->dropColumn('remark');
            $table->dropColumn('upload_mode');
        });
    }
}
