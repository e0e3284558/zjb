<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactsContactsTelPositionContactsEmailToOrgs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orgs', function (Blueprint $table) {
            $table->string('contacts',30)->default('');
            $table->string('contacts_tel',30)->default('');
            $table->string('contacts_postion',30)->nullable();
            $table->string('contacts_email',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orgs', function (Blueprint $table) {
            $table->dropColumn('contacts');
            $table->dropColumn('contacts_tel');
            $table->dropColumn('contacts_postion');
            $table->dropColumn('contacts_email');
        });
    }
}
