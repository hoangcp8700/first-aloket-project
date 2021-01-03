<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('section_id')->nullable();

            $table->string('product_code');
            $table->string('name');
            $table->string('slug');
            $table->string('color');
            $table->float('price');
            $table->float('discount')->nullable();
            $table->string('keyword')->nullable();
            $table->integer('stock')->nullable();
            $table->string('fit')->nullable();
            $table->string('fabric')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('category_id')
            ->references('id')
            ->on('categories')
            ->onDelete('cascade');

            $table->foreign('section_id')
            ->references('id')
            ->on('sections')
            ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
