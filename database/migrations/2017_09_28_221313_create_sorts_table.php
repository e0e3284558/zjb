<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSortsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sorts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('分类名');
            $table->integer('parent_id')->default(0)->comment('父分类');
            $table->string('parent_path')->default('')->comment('分类路径');
            $table->string('org_id')->default('')->comment('所属公司');
            $table->string('operator')->default('')->comment('操作员');
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
        Schema::dropIfExists('sorts');
    }
}
