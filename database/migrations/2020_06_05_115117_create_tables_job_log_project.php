<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablesJobLogProject extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("comment")->nullable();
            $table->timestamps();
        });

        Schema::create("job_log", function (Blueprint $table) {
           $table->id();

           $table->unsignedBigInteger("services_item_id");
           $table->unsignedBigInteger("user_id");
           $table->unsignedBigInteger("client_id");
           $table->unsignedBigInteger("project_id")->nullable();

           $table->string("price");
           $table->string("coefficient")->default("0");
           $table->string("comment")->nullable();

            $table->timestamps();
        });

        Schema::table("job_log", function (Blueprint $table) {

            $table->foreign("services_item_id")
                ->references("id")
                ->on("services_item");

            $table->foreign("user_id")
                ->references("id")
                ->on("users");

            $table->foreign("client_id")
                ->references("id")
                ->on("clients");

            $table->foreign("project_id")
                ->references("id")
                ->on("projects");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tables_job_log_project');
    }
}
