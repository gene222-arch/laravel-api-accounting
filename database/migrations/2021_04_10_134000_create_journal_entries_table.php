<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date')->default(now());
            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('journal_entry_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_entry_id');
            $table->foreignId('item_id');
            $table->foreignId('chart_of_account_id');
            $table->unsignedDecimal('debit', 10, 2)->default(0.00);
            $table->unsignedDecimal('credit', 10, 2)->default(0.00);

            $table->unique([
                'journal_entry_id',
                'item_id'
            ]);

            $table->foreign('journal_entry_id')
                ->references('id')
                ->on('journal_entries')
                ->cascadeOnDelete();

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->cascadeOnDelete();

            $table->foreign('chart_of_account_id')
                ->references('id')
                ->on('chart_of_accounts')
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
        Schema::dropIfExists('journal_entry_details');
        Schema::dropIfExists('journal_entries');
    }
}
