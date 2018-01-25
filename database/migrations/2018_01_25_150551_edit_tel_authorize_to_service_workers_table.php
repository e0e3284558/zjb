<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditTelAuthorizeToServiceWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_workers', function (Blueprint $table) {
            $table->integer('tel_authorize')->default(0)->change();
            $table->renameColumn('tel_authorize', 'phone_authorize');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_workers', function (Blueprint $table) {
            //
        });
    }
}
