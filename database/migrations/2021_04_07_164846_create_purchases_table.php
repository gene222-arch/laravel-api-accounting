<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->foreignId('account_id')->nullable();
            $table->foreignId('vendor_id')->nullable();
            $table->foreignId('expense_category_id')->nullable();
            $table->foreignId('payment_method_id')->nullable();
            $table->foreignId('currency_id')->nullable();
            $table->timestamp('date')->default(now());
            $table->unsignedDecimal('amount', 10, 2);
            $table->text('description')->nullable();
            $table->string('recurring')->default('No');
            $table->text('reference')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();

            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->nullOnDelete();

            $table->foreign('vendor_id')
                ->references('id')
                ->on('vendors')
                ->nullOnDelete();

            $table->foreign('expense_category_id')
                ->references('id')
                ->on('expense_categories')
                ->nullOnDelete();

            $table->foreign('payment_method_id')
                ->references('id')
                ->on('payment_methods')
                ->nullOnDelete();

            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
                ->nullOnDelete();

        });

        Schema::create('bill_purchase', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id');
            $table->foreignId('bill_id');

            $table->unique([
                'purchase_id',
                'bill_id'
            ]);

            $table->foreign('purchase_id')
                ->references('id')
                ->on('purchases')
                ->cascadeOnDelete();

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
        Schema::dropIfExists('bill_purchase');
        Schema::dropIfExists('purchases');
    }
}
