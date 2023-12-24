<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->increments('product_id');
            // $table->integer('cate_product_id');
            // $table->integer('wood_type_id');
            $table->string('product_name');
            $table->string('product_tags');
            $table->string('product_slug');
            $table->integer('product_qty')->default(0);
            $table->text('product_desc');
            $table->text('product_content');
            $table->integer('product_price');
            $table->integer('product_cost');
            $table->string('product_image');
            $table->integer('product_status');
            $table->string('product_views')->default(0);

            $table->unsignedInteger('cate_product_id');
            $table->foreign('cate_product_id')->references('cate_id')->on('cate_product')->onDelete('cascade');

            $table->unsignedInteger('wood_type_id');
            $table->foreign('wood_type_id')->references('wood_id')->on('wood')->onDelete('cascade');
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
        Schema::dropIfExists('product');
    }
}
