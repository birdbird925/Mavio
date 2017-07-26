<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
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
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('images');
            $table->integer('vendor_id')->nullable()->unsigned();
            $table->integer('type_id')->nullable()->unsigned();
            $table->tinyInteger('visible')->default(0);
            $table->tinyInteger('deleted')->default(0);
            $table->decimal('price', 7, 2);
            $table->decimal('compare_price', 7, 2)->nullable();
            $table->integer('quantity')->default(0);
            $table->timestamps();

            $table->foreign('vendor_id')
                  ->references('id')->on('product_vendors')
                  ->onDelete('set null');
            $table->foreign('type_id')
                  ->references('id')->on('product_types')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
