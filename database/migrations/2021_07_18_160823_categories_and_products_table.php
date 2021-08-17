<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoriesAndProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("categories",function (Blueprint $table){
            $table->id();
            $table->string("name");
            $table->unsignedBigInteger("parent_id");
            $table->timestamps();
        });

        Schema::create("category_product",function (Blueprint $table){
            $table->unsignedBigInteger("category_id");
            $table->foreign("category_id")->references("id")->on('categories');

            $table->unsignedBigInteger('product_id');
            $table->foreign("product_id")->references("id")->on("products");

            $table->primary(['category_id',"product_id"]);
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("category_product");
        Schema::dropIfExists('categories');
    }
}
