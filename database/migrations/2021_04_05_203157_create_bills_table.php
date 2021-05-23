<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('currency_id');
            $table->foreignId('expense_category_id');
            $table->foreignId('vendor_id');
            $table->string('bill_number');
            $table->unsignedBigInteger('order_no');
            $table->timestamp('date')->default(now());
            $table->timestamp('due_date')->default(now());
            $table->string('recurring')->default('No');
            $table->string('status')->default('Draft');
            $table->timestamps();

            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
                ->cascadeOnDelete();

            $table->foreign('expense_category_id')
                ->references('id')
                ->on('expense_categories')
                ->cascadeOnDelete();
            
                $table->foreign('vendor_id')
                ->references('id')
                ->on('vendors')
                ->cascadeOnDelete();
        });

        Schema::create('bill_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id');
            $table->foreignId('item_id');
            $table->foreignId('discount_id')->nullable();
            $table->foreignId('tax_id')->nullable();
            $table->string('item');
            $table->unsignedDecimal('price', 10, 2);
            $table->unsignedInteger('quantity');
            $table->unsignedDecimal('amount', 10, 2);
            $table->unsignedDecimal('discount', 10, 2)->default(0.00);
            $table->unsignedDecimal('tax', 10, 2)->default(0.00);
            $table->timestamps();

            $table->unique([
                'bill_id',
                'item_id'
            ]);

            $table->foreign('bill_id')
                ->references('id')
                ->on('bills')
                ->cascadeOnDelete();

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->cascadeOnDelete();

            $table->foreign('discount_id')
                ->references('id')
                ->on('discounts')
                ->nullOnDelete();
        });

        Schema::create('bill_payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id');
            $table->unsignedDecimal('total_discounts', 10, 2)->default(0.00);
            $table->unsignedDecimal('total_taxes', 10, 2)->default(0.00);
            $table->unsignedDecimal('sub_total', 10, 2);
            $table->unsignedDecimal('total', 10, 2);
            $table->unsignedDecimal('amount_due', 10, 2)->default(0.00);
            $table->unsignedDecimal('over_due', 10, 2)->default(0.00);

            $table->foreign('bill_id')
                ->references('id')
                ->on('bills')
                ->cascadeOnDelete();
        });

        Schema::create('bill_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->index();
            $table->string('status')->default('Draft');
            $table->text('description');
            $table->timestamps();

            $table->foreign('bill_id')
                ->references('id')
                ->on('bills')
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
        Schema::dropIfExists('bill_histories');
        Schema::dropIfExists('bill_payment_details');
        Schema::dropIfExists('bill_details');
        Schema::dropIfExists('bills');
    }
}
