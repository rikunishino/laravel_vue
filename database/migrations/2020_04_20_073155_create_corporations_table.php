<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorporationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('login_id')->comment('ログインID');
            $table->string('password')->comment('パスワード');
            $table->string('name', 20)->comment('法人名');
            $table->string('mail', 255)->comment('メールアドレス');
            $table->string('address', 100)->comment('住所');
            $table->string('postal_code', 8)->comment('郵便番号');
            $table->string('tel', 13)->comment('電話番号');
            $table->string('fax', 13)->comment('Fax番号');
            $table->timestamp('create_ts')->useCurrent();
            $table->timestamp('update_ts')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->boolean('is_deleted')->default(false)->comment('削除フラグ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corporations');
    }
}
