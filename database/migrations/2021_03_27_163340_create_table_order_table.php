<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('order_id');
            // $table->integer('shipping_id');
            $table->integer('customer_id');
            $table->string('order_total');
            $table->string('order_status');
            $table->string('order_reason')->nullable();
            $table->string('order_date');
            $table->unsignedInteger('shipping_id');
            $table->foreign('shipping_id')->references('shipping_id')->on('shipping')->onDelete('cascade');
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
        Schema::dropIfExists('order');
    }
}
