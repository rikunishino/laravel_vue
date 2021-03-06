<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_carts', function (Blueprint $table) {
            $table->increments('id')->comment('カートID');
            $table->integer('order_id')->unsigned()->comment('注文ID');
            // $table->integer('school_id')->unsigned()->comment('学校ID');
            $table->string('cart_name')->comment('カート名（クラス名）');
            $table->integer('subtotal')->comment('小計');
            $table->timestamp('create_ts')->useCurrent()->comment('作成日時');
            $table->timestamp('update_ts')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->boolean('is_deleted')->default(false)->comment('削除フラグ');
            $table->foreign('order_id')->references('id')->on('orders');
            // $table->foreign('school_id')->references('id')->on('schools');

            //$table->primary(['id', 'order_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_carts');
    }
}
