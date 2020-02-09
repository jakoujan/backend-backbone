<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionableCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transactional_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('system_customer')->unsigned();
            $table->string('business_name');
            $table->string('tax_id')->unique();;
            $table->string('contact');
            $table->string('telephone');
            $table->string('email')->unique();
            $table->string('street');
            $table->string('internal_number');
            $table->string('external_number');
            $table->string('settlement');
            $table->string('city');
            $table->string('county');
            $table->integer('state');
            $table->string('postal_code');
            $table->integer('country');
            $table->integer('status');
            $table->rememberToken();
            $table->timestamps();
            
            $table->foreign('system_customer')->references('id')->on('tbl_system_customer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_transactional_customers');
    }
}
