<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orgs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('名称');
            $table->string('logo')->default('')->comment('logo');
            $table->string('code')->default('')->comment('组织机构代码');
            $table->boolean('status')->default(1)->comment('状态1可用0不可用');
            $table->string('remark')->default('')->comment('备注');
            $table->softDeletes();
            $table->timestamps();
            $table->index(['name','status']);
//            $table->unique('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orgs');
    }
}
