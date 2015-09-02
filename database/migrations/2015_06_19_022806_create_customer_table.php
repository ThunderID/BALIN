<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique();
            $table->string('password');
            $table->date('dob');
            $table->text('address');
            $table->string('zip_code');
            $table->string('phone');
            $table->string('gender');
            $table->string('coupon_code');
            $table->string('coupon_balance');
            $table->string('profile_photo');
            $table->date('join_date');
            $table->string('sso_type');
            $table->string('sso_id');
            $table->text('sso_data');
            $table->string('remember_token');
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
        Schema::drop('customers');
    }
}
