<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_account_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_account_id');
            $table->foreignId('to_account_id');
            $table->foreignId('payment_method_id');
            $table->unsignedDecimal('amount', 10, 2)->default(0);
            $table->timestamp('transferred_at')->default(now());
            $table->text('description')->nullable();
            $table->string('reference')->nullable();
            $table->timestamps();

            $table->foreign('from_account_id')
                ->references('id')
                ->on('accounts')
                ->cascadeOnDelete();

            $table->foreign('to_account_id')
                ->references('id')
                ->on('accounts')
                ->cascadeOnDelete();

            $table->foreign('payment_method_id')
                ->references('id')
                ->on('payment_methods')
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
        Schema::dropIfExists('bank_account_transfers');
    }
}
