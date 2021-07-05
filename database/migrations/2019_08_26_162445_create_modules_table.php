<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('route')->nullable();
            $table->text('icon')->nullable();
            $table->integer('module_id')->unsigned()->nullable();
            $table->boolean('status')->default(true);
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->softDeletes();

            //Foreign
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
        });

        Schema::create('sub_menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('route')->nullable();
            $table->text('icon')->nullable();
            $table->integer('menu_id')->nullable()->unsigned();
            $table->integer('sub_menu_id')->nullable()->unsigned();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();

            //Foreign
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->foreign('sub_menu_id')->references('id')->on('sub_menus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_menus');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('modules');
    }
}
