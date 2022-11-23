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
            $table->unsignedBigInteger('category_id')->nullable();
            $table->integer('subcat_id')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->string('product_name',100)->nullable();
            $table->string('regular_price',100)->nullable();
            $table->string('pr_item_price',100)->nullable();
            $table->string('stock',100)->nullable();
            $table->string('product_image',100)->nullable();
            $table->string('product_slug',100)->nullable();
            $table->string('sale_price',100)->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
