<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariantAttributesTable extends Migration
{
    public function up()
    {
        Schema::create('variant_attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_variant_id');
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('attribute_value_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('product_variant_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
            $table->foreign('attribute_value_id')->references('id')->on('attribute_values')->onDelete('cascade');

            // Unique constraint to ensure one attribute per variant
            $table->unique(['product_variant_id', 'attribute_id'], 'unique_variant_attribute');
        });
    }

    public function down()
    {
        Schema::dropIfExists('variant_attributes');
    }
}
