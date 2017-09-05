<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrgServiceProviderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('org_service_provider', function (Blueprint $table) {
            $table->integer('org_id')->unsigned();
            $table->integer('service_provider_id')->unsigned();
            $table->boolean('status')->default(0)->comment('内部服务商|0，外部服务商|1');
            $table->foreign('org_id')->references('id')->on('orgs');
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
        Schema::dropIfExists('service_provider_org');
    }
}
