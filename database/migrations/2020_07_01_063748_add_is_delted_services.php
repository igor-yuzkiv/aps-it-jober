<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDeltedServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services_item', function (Blueprint $table) {
            $table->boolean("is_deleted")->default(false);
        });
        Schema::table('services_group', function (Blueprint $table) {
            $table->boolean("is_deleted")->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services_item', function (Blueprint $table) {
           $table->dropColumn("is_deleted");
        });
        Schema::table('services_group', function (Blueprint $table) {
           $table->dropColumn("is_deleted");
        });
    }
}
