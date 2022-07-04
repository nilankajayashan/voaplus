<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile_number')->nullable();
            $table->integer('device_count')->default(0);
            $table->integer('stream_counter')->default(0);
            $table->string('stream_token')->nullable();
            $table->string('browser_token')->nullable();
            $table->integer('account_state')->default(0);
            $table->dateTime('payment_date')->nullable();
            $table->string('verification')->nullable();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
