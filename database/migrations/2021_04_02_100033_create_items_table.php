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
