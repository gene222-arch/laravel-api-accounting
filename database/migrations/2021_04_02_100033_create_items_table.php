<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->string('barcode');
            $table->foreignId('category_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->unsignedDecimal('price', 10, 2)->default(0.00);
            $table->unsignedDecimal('cost', 10, 2);
            $table->string('sold_by');
            $table->boolean('is_for_sale')->default(false);
            $table->string('image')->nullable();
            $table->timestamps();

            $table->unique([
                'sku',
                'barcode',
                'name'
            ]);

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->nullOnDelete();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id');
            $table->foreignId('tax_id');
            $table->unsignedDecimal('total_tax');
            $table->timestamps();

            $table->unique([
                'item_id',
                'tax_id',
            ]);

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->nullOnDelete();

                
            $table->foreign('tax_id')
                ->references('id')
                ->on('tax')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
