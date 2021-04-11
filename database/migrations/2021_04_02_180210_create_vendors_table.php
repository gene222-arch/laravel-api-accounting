<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('currency_id');
            $table->string('name');
            $table->string('email');
            $table->unsignedInteger('tax_number');
            $table->string('phone');
            $table->string('website')->nullable();
            $table->string('address');
            $table->string('reference')->nullable();
            $table->string('image')->nullable();
            $table->boolean('enabled')->default(false);
            $table->timestamps();

            $table->unique([
                'email',
                'tax_number',
                'phone'
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
        Schema::dropIfExists('vendors');
    }
}
