<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->timestamp('birth_date');
            $table->char('gender', 6);
            $table->char('phone', 15);
            $table->string('address');
            $table->boolean('enabled')->default(false);
            $table->timestamps();

            $table->unique([
                'email',
                'phone'
            ]);
        });

        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->foreignId('currency_id');
            $table->unsignedDecimal('amount')->default(0.00);
            $table->char('tax_number', 11);
            $table->string('bank_account_number');
            $table->timestamp('hired_at');

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->cascadeOnDelete();

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
        Schema::dropIfExists('salary');
        Schema::dropIfExists('employees');
    }
}
