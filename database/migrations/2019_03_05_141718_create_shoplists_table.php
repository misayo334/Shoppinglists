<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoplistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoplists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shoplist_name');
            $table->integer('created_by')->unsigned()->index();
            $table->string('status');
            $table->integer('assigned_to')->unsigned()->index();
            $table->timestamps();
            
            // 外部キー制約
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('assigned_to')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shoplists');
    }
}
