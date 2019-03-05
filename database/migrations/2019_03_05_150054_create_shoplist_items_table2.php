<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShoplistItemsTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoplist_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shoplist_item_id')->unsigned()->index();
            $table->integer('shoplist_id')->unsigned()->index();
            $table->string('item_name');
            $table->integer('qty');
            $table->string('item_status', 20);
            $table->timestamps();
            
            // 外部キー制約
            $table->foreign('shoplist_id')->references('id')->on('shoplists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shoplist_items');
    }
}
