<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subject_id')->unsigned()->comment('科目ID');
            $table->string('product_name')->comment('商品名');
            $table->integer('price')->comment('金額');
            $table->integer('sort_no')->comment('ソートNo');
            $table->timestamp('create_ts')->useCurrent();
            $table->timestamp('update_ts')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->boolean('is_deleted')->default(false)->comment('削除フラグ');
            $table->foreign('subject_id')->references('id')->on('subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
