<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceWorkerServiceProvider extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_provider_service_worker', function (Blueprint $table) {
            $table->integer('service_worker_id')->unsigned();
            $table->integer('service_provider_id')->unsigned();
            $table->boolean('status')->default(0)->comment('内部服务商|0，外部服务商|1');
            $table->foreign('service_worker_id')->references('id')->on('service_workers');
            $table->foreign('service_provider_id')->references('id')->on('service_providers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_worker_service_provider');
    }
}
