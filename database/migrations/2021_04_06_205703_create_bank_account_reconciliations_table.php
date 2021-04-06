<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankAccountReconciliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_account_reconciliations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id');
            $table->timestamp('started_at')->default(now());
            $table->timestamp('ended_at')->default(now());
            $table->decimal('closing_balance', 10, 2)->default(0.00);
            $table->decimal('cleared_amount', 10, 2)->default(0.00);
            $table->decimal('difference', 10, 2)->default(0.00);
            $table->string('status')->default('Unreconciled');
            $table->timestamps();

            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
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
        Schema::dropIfExists('bank_account_reconciliations');
    }
}
