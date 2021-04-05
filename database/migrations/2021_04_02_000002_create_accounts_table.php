<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('currency_id')->index();
            $table->string('name');
            $table->unsignedInteger('number');
            $table->unsignedDecimal('opening_balance', 10, 2)->default(0.00);
            $table->unsignedDecimal('balance', 10, 2)->default(0.00);
            $table->timestamps();

            $table->unique([
                'name',
                'number'
            ]);

            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
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
        Schema::dropIfExists('accounts');
    }
}
