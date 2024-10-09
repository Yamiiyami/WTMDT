<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('product_variant_id')->nullable();
            $table->string('file_name');
            $table->string('url');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');

            // Unique constraints to ensure only one primary image per product and per variant
            $table->unique(['product_id', 'is_primary'], 'unique_primary_image_product');
            $table->unique(['product_variant_id', 'is_primary'], 'unique_primary_image_variant');
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
}
