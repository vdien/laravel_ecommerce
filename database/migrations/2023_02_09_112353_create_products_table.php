<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("product_name");
            $table->string("product_short_des");
            $table->string("product_long_des");
            $table->string("sku");
            $table->integer("price");
            $table->string("product_category_name");
            $table->string("product_subcategory_name");
            $table->integer("product_category_id");
            $table->string("product_subcategory_id");
            $table->string("product_img");
            $table->string("product_img_child");
            $table->integer("quantity");
            $table->integer("status");
            $table->integer("stock");
            $table->string("slug");
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
        Schema::dropIfExists('products');
    }
};
