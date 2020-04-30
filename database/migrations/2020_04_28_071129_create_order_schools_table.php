<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_schools', function (Blueprint $table) {
            $table->increments('id')->comment('注文学校ID');
            $table->integer('order_id')->unsigned()->comment('注文ID');
            $table->integer('school_id')->unsigned()->comment('学校ID');
            $table->integer('subtotal')->comment('小計');
            $table->timestamp('create_ts')->useCurrent()->comment('作成日時');
            $table->timestamp('update_ts')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->boolean('is_deleted')->default(false)->comment('削除フラグ');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('school_id')->references('id')->on('schools');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_schools');
    }
}
