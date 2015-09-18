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
            $table->integer('customer_id');
            $table->string('invoice_no');
            $table->date('date');
            $table->string('coupon_code');
            $table->integer('unique_number');
            $table->double('total_product_price');
            $table->double('shipping_cost');
            $table->double('total_discount');
            $table->double('total_price');
            $table->integer('status');
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
