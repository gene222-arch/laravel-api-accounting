<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->unique();
            $table->foreignId('supplier_id')->nullable();
            $table->foreignId('warehouse_id');
            $table->unsignedBigInteger('in_stock');
            $table->unsignedBigInteger('stock_in')->default(0);
            $table->unsignedBigInteger('stock_out')->default(0);
            $table->unsignedBigInteger('bad_stock')->default(0);    
            $table->unsignedBigInteger('minimum_stock')->default(0);    
            $table->timestamps();

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->cascadeOnDelete();

            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->nullOnDelete();

            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
