<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("services_group", function (Blueprint $table) {
            $table->id();
            $table->text("name");

            $table->timestamps();

        });

        Schema::create("services_item", function (Blueprint $table) {
            $table->id();
            $table->text("name");
            $table->string("price");
            $table->unsignedBigInteger("unit_id");
            $table->unsignedBigInteger("service_group_id");
            $table->timestamps();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
        });

        Schema::table("services_item", function (Blueprint $table) {
            $table->foreign("service_group_id")
                ->references("id")
                ->on("services_group")
                ->onDelete('cascade');

            $table->foreign("unit_id")
                ->references("id")
                ->on("units");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("services_item");
        Schema::dropIfExists("services_group");
    }
}
