<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filepath')->nullable();

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('image_id');

            $table->foreign('product_id')
                  ->references('id')->on('products')
                //   ->onDelete('strict')
                  ->onUpdate('cascade');

            $table->foreign('image_id')
                  ->references('id')->on('images')
                //   ->onDelete('strict')
                  ->onUpdate('cascade');

            $table->unique(array('product_id', 'image_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_product');
    }
}
