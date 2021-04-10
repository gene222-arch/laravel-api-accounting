<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->string('estimate_number');
            $table->timestamp('estimated_at')->default(now());
            $table->timestamp('expired_at')->default(now());
            $table->string('status')->default('Draft');       
            $table->boolean('enable_reminder');
            $table->timestamps();

            $table->unique([
                'estimate_number'
            ]);

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->cascadeOnDelete();
        });

        Schema::create('estimate_invoice_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estimate_invoice_id');
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
                'estimate_invoice_id',
                'item_id'
            ]);

            $table->foreign('estimate_invoice_id')
                ->references('id')
                ->on('estimate_invoices')
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

        Schema::create('estimate_invoice_payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estimate_invoice_id');
            $table->unsignedDecimal('total_discounts', 10, 2)->default(0.00);
            $table->unsignedDecimal('total_taxes', 10, 2)->default(0.00);
            $table->unsignedDecimal('sub_total', 10, 2);
            $table->unsignedDecimal('total', 10, 2);
            $table->timestamps();

            $table->foreign('estimate_invoice_id')
                ->references('id')
                ->on('estimate_invoices')
                ->cascadeOnDelete();
        });

        Schema::create('estimate_invoice_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estimate_invoice_id')->index();
            $table->string('status')->default('Draft');
            $table->text('description');
            $table->timestamps();

            $table->foreign('estimate_invoice_id')
                ->references('id')
                ->on('estimate_invoices')
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
        Schema::dropIfExists('estimate_invoice_details');
        Schema::dropIfExists('estimate_invoice_payment_details');
        Schema::dropIfExists('estimate_invoice_histories');
        Schema::dropIfExists('estimate_invoices');
    }
}
