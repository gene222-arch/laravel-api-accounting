<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->string('number')->nullable();
            $table->foreignId('account_id');
            $table->foreignId('income_category_id')->nullable();
            $table->foreignId('expense_category_id')->nullable();
            $table->foreignId('payment_method_id');
            $table->string('category');
            $table->string('type');
            $table->unsignedDecimal('amount', 10, 2);
            $table->unsignedDecimal('deposit', 10, 2)->nullable();
            $table->unsignedDecimal('withdrawal', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('contact')->nullable();
            $table->timestamps();
       

            $table->foreign('payment_method_id')
                ->references('id')
                ->on('payment_methods')
                ->cascadeOnDelete();

            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->cascadeOnDelete();

            $table->foreign('income_category_id')
                ->references('id')
                ->on('income_categories')
                ->cascadeOnDelete();

            $table->foreign('expense_category_id')
                ->references('id')
                ->on('expense_categories')
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
        Schema::dropIfExists('transactions');
    }
}
