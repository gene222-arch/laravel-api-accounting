<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->foreignId('model_id');
            $table->timestamp('date');
            $table->unsignedDecimal('amount', 10, 2);
            $table->string('account')->default('Cash');
            $table->string('currency');
            $table->text('description')->nullable();
            $table->string('payment_method')->default('Cash');
            $table->text('reference')->nullable();
            $table->timestamps();

            $table->index([
                'model_type',
                'model_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
