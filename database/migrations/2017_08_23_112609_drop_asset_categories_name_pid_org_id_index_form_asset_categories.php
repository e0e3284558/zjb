<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropAssetCategoriesNamePidOrgIdIndexFormAssetCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_categories', function (Blueprint $table) {
            $table->dropIndex('asset_categories_name_pid_org_id_index');
            $table->index('name');
            $table->index('pid');
            $table->index('org_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_categories', function (Blueprint $table) {
            //
        });
    }
}
