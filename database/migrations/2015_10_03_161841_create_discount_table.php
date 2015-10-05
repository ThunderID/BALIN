<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Discounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->double('promo_price');
            $table->date('start_date');
            $table->date('end_date');   
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
        Schema::drop('Discounts');
    }
}
