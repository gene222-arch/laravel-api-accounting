<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->nullable();
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('income_category_id')->nullable();
            $table->foreignId('payment_method_id')->nullable();
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

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->nullOnDelete();

            $table->foreign('income_category_id')
                ->references('id')
                ->on('income_categories')
                ->nullOnDelete();

            $table->foreign('payment_method_id')
                ->references('id')
                ->on('payment_methods')
                ->nullOnDelete();

        });

        Schema::create('invoice_revenue', function (Blueprint $table) {
            $table->id();
            $table->foreignId('revenue_id');
            $table->foreignId('invoice_id');
            

            $table->unique([
                'revenue_id',
                'invoice_id'
            ]);

            $table->foreign('revenue_id')
                ->references('id')
                ->on('revenues')
                ->cascadeOnDelete();

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
        Schema::dropIfExists('invoice_revenue');
        Schema::dropIfExists('revenues');
    }
}
