<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('currency_id');
            $table->string('name');
            $table->string('email');
            $table->string('tax_number');
            $table->char('phone', 15);
            $table->string('website')->nullable();
            $table->string('address');
            $table->text('reference')->nullable();
            $table->boolean('enabled')->default(false);
            $table->timestamps();

            $table->unique([
                'email',
                'tax_number',
                'phone',
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
        Schema::dropIfExists('customers');
    }
}
