<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOrderDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_detail', function (Blueprint $table) {
            $table->increments('order_detail_id');
            // $table->integer('order_id');
            // $table->integer('product_id');
            $table->string('product_name');
            $table->string('product_price');
            $table->integer('product_qty');
            
            $table->unsignedInteger('order_id');
            $table->foreign('order_id')->references('order_id')->on('order')->onDelete('cascade');
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('product_id')->on('product')->onDelete('cascade');
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
        Schema::dropIfExists('order_detail');
    }
}
