<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->integer('package_id')->autoIncrement();
            $table->string('name');
            $table->float('one_month_price');
            $table->float('one_year_price');
            $table->integer('device_count')->default(1);
            $table->text('style_class')->default('bg-light');
            $table->string('status')->default('active');
            $table->text('siyatha_link')->nullable();
            $table->text('startamil_link')->nullable();
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
        Schema::dropIfExists('packages');
    }
}
