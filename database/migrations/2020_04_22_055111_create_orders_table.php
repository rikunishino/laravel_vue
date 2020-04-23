<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id')->comment('注文ID');
            $table->integer('corporation_id')->unsigned()->comment('法人ID');
            $table->string('name', 20)->comment('法人名');
            $table->string('mail', 255)->comment('メールアドレス');
            $table->string('address', 100)->comment('住所');
            $table->string('postal_code', 8)->comment('郵便番号');
            $table->string('tel', 13)->comment('電話番号');
            $table->string('fax', 13)->comment('Fax番号');
            $table->integer('total_price')->comment('合計金額');
            $table->tinyInteger('tax_rate')->comment('消費税率');
            $table->tinyInteger('is_canceled')->default(0)->comment('取り消しフラグ');
            $table->timestamp('create_ts')->useCurrent()->comment('作成日時');
            $table->timestamp('update_ts')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->comment('更新日時');
            $table->boolean('is_deleted')->default(false)->comment('削除フラグ');
            $table->foreign('corporation_id')->references('id')->on('corporations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
