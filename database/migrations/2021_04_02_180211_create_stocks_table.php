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
            $table->foreignId('vendor_id')->nullable();
            $table->unsignedBigInteger('in_stock')->default(0);
            $table->unsignedBigInteger('incoming_stock')->default(0);
            $table->unsignedBigInteger('stock_in')->default(0);
            $table->unsignedBigInteger('stock_out')->default(0);
            $table->unsignedBigInteger('bad_stock')->default(0);    
            $table->unsignedBigInteger('minimum_stock')->default(0);    
            $table->timestamps();

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->cascadeOnDelete();

            $table->foreign('vendor_id')
                ->references('id')
                ->on('vendors')
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
        Schema::dropIfExists('stocks');
    }
}
