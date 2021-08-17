<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("attribute_id");
            $table->foreign("attribute_id")->references("id")->on("attributes")->onDelete("cascade");

            $table->string("value");
            $table->timestamps();
        });

        Schema::create("attribute_product",function (Blueprint $table){
            $table->unsignedBigInteger("attribute_id");
            $table->foreign("attribute_id")->references("id")->on("attributes")->onDelete("cascade");

            $table->unsignedBigInteger("value_id");
            $table->foreign("value_id")->references("id")->on("attribute_values")->onDelete("cascade");

            $table->unsignedBigInteger("product_id");
            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade");

            $table->primary(["attribute_id","value_id","product_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_values');
        Schema::dropIfExists('attribute_product');
    }
}
