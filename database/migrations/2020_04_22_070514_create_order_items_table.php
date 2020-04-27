<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id')->comment('アイテムID');
            $table->integer('order_id')->unsigned()->comment('注文ID');
            //$table->('cart_id')->unsigned()->comment('カートID');
            $table->integer('product_id')->unsigned()->comment('商品ID');
            $table->integer('amount')->comment('数量');
            $table->timestamp('create_ts')->useCurrent()->comment('作成日時');
            $table->timestamp('update_ts')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->boolean('is_deleted')->default(false)->comment('削除フラグ');
            $table->foreign('order_id')->references('id')->on('orders');
            // $table->foreign('cart_id')->references('id')->on('order_carts');
            $table->foreign('product_id')->references('id')->on('products');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
