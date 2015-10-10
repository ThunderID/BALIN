<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('supplier_id')->unsigned()->index();
            $table->string('ref_number', 255);
            $table->string('referral_code', 255)->nullable();
            $table->enum('type', ['sell', 'buy']);
            $table->enum('status', ['waiting', 'hold', 'paid', 'shipped', 'delivered', 'canceled']);
            $table->datetime('transacted_at');
            $table->integer('unique_number');
            $table->double('shipping_cost');
            $table->double('referral_discount');
            $table->double('amount');
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
        Schema::drop('transactions');
    }
}
