<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment("合同名称");
            $table->string("first_party")->nullable()->comment("合同甲方");
            $table->string("second_party")->nullable()->comment("合同乙方");
            $table->string("third_party")->nullable()->comment("合同丙方");
            $table->integer("file_id")->nullable()->comment("合同文件存储");
            $table->string("remarks")->nullable()->comment("备注说明");
            $table->integer("org_id")->nullable()->comment("合同文件存储路径");
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
        Schema::dropIfExists('contracts');
    }
}
