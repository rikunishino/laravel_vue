<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_items', function (Blueprint $table) {
            $table->integer('id')->comment('商品ID');
            $table->integer('order_id')->unsigned()->comment('注文ID');
            $table->integer('amount')->comment('数量');
            $table->timestamp('create_ts')->useCurrent()->comment('作成日時');
            $table->timestamp('update_ts')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->boolean('is_deleted')->default(false)->comment('削除フラグ');
            $table->foreign('order_id')->references('id')->on('orders');

            $table->primary(['id', 'order_id']);
        });

        Schema::table('orders_items', function (Blueprint $table) {
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
        Schema::dropIfExists('orders_items');
    }
}
