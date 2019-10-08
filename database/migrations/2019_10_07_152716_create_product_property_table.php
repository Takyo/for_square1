<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_property', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content')->nullable();

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('property_id');

            $table->foreign('product_id')
                  ->references('id')->on('products')
                //   ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('property_id')
                  ->references('id')->on('properties')
                //   ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->unique(['product_id', 'property_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_property');
    }
}
