<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->string('invoice_number');
            $table->unsignedBigInteger('order_no');
            $table->timestamp('date')->default(now());
            $table->timestamp('due_date')->default(now());
            $table->string('recurring')->default('No');
            $table->string('status')->default('Draft');
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->cascadeOnDelete();
        });

        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id');
            $table->foreignId('item_id');
            $table->foreignId('discount_id')->nullable();
            $table->string('item');
            $table->unsignedDecimal('price', 10, 2);
            $table->unsignedInteger('quantity');
            $table->unsignedDecimal('amount', 10, 2);
            $table->unsignedDecimal('discount', 10, 2)->default(0.00);
            $table->unsignedDecimal('tax', 10, 2)->default(0.00);
            $table->timestamps();

            $table->unique([
                'invoice_id',
                'item_id'
            ]);

            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
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

        Schema::create('invoice_payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id');
            $table->unsignedDecimal('total_discounts', 10, 2)->default(0.00);
            $table->unsignedDecimal('total_taxes', 10, 2)->default(0.00);
            $table->unsignedDecimal('sub_total', 10, 2);
            $table->unsignedDecimal('total', 10, 2);
            $table->unsignedDecimal('amount_due', 10, 2)->default(0.00);
            $table->unsignedDecimal('over_due', 10, 2)->default(0.00);

            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
                ->cascadeOnDelete();
        });

        Schema::create('invoice_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->index();
            $table->string('status');
            $table->text('description');
            $table->timestamps();

            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
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
        Schema::dropIfExists('invoice_histories');
        Schema::dropIfExists('invoice_payment_details');
        Schema::dropIfExists('invoice_details');
        Schema::dropIfExists('invoices');
    }
}
