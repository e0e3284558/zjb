<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditNameToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('name',50)->nullable()->change();
            $table->string('tel',20)->nullable()->change();
            $table->string('email',50)->nullable()->change();
            $table->string('password')->nullable()->change();
            $table->integer('org_id')->nullable()->change();
            $table->integer('department_id')->nullable()->change();
            $table->string('username',50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
