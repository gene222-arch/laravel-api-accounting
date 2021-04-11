<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 15);
            $table->string('address');
            $table->boolean('default_warehouse')->default(false);
            $table->boolean('enabled')->default(false);
            $table->timestamps();

            $table->unique([
                'name',
                'email',
                'phone'
            ]);
        });

        Schema::create('stock_warehouse', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id');
            $table->foreignId('stock_id');

            $table->foreign('warehouse_id')
                ->references('id')
                ->on('warehouses')
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
        Schema::dropIfExists('stock_warehouse');
        Schema::dropIfExists('warehouses');
    }
}
