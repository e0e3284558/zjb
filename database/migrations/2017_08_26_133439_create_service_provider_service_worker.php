<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceProviderServiceWorker extends Migration
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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_provider_service_worker');
    }
}
