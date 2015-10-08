<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('courier_id')->unsigned()->index();
            $table->integer('transaction_id')->unsigned()->index();
            $table->string('receipt_number', 255)->nullable();
            $table->date('ondate');
            $table->string('name', 255);
            $table->string('phone', 20);
            $table->string('address');
            $table->string('postal_code', 6);
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
        Schema::drop('shipments');
    }
}
