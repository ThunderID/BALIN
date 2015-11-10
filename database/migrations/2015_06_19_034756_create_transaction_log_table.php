<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->unsigned()->index();
            $table->enum('status', ['cart', 'wait', 'paid', 'shipping', 'delivered', 'canceled', 'abandoned']);
            $table->datetime('changed_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transaction_logs');
    }
}
