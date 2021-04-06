<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->string('stock_adjustment_number')->unique();
            $table->string('reason');
            $table->timestamps();
        });

        Schema::create('stock_adjustment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_adjustment_id');
            $table->foreignId('stock_id');
            $table->string('item');
            $table->unsignedInteger('book_quantity');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('physical_quantity');
            $table->unsignedDecimal('unit_price', 10, 2);
            $table->unsignedDecimal('amount', 10, 2);

            $table->unique([
                'stock_adjustment_id',
                'stock_id'
            ]);

            $table->foreign('stock_adjustment_id')
                ->references('id')
                ->on('stock_adjustments')
                ->cascadeOnDelete();

            $table->foreign('stock_id')
                ->references('id')
                ->on('stocks')
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
        Schema::dropIfExists('stock_adjustment_details');
        Schema::dropIfExists('stock_adjustments');
    }
}
