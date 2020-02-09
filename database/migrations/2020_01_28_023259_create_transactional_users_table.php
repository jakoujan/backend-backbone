<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionableUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('tbl_transactional_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer')->unsigned();
            $table->string('name');
            $table->string('user')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->json('modules');
            $table->string('api_token', 80)
                    ->unique()
                    ->nullable()
                    ->default(null);
            $table->rememberToken();
            $table->integer('status');
            $table->timestamps();

            $table->foreign('customer')->references('id')->on('tbl_transactional_customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('tbl_transactional_users');
    }

}
