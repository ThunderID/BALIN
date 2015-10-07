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
            $table->string('referral_code', 255);
            $table->enum('type', ['sell', 'buy']);
            $table->enum('status', ['waiting', 'paid', 'shipping', 'delivered', 'canceled']);
            $table->datetime('transacted_at');
            $table->integer('unique_number');
            $table->double('shipping_cost');
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
