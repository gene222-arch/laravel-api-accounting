<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->foreignId('account_id');
            $table->foreignId('expense_category_id');
            $table->foreignId('payment_method_id');
            $table->timestamp('from_date')->default(now());
            $table->timestamp('to_date')->default(now());
            $table->timestamp('payment_date')->default(now());
            $table->string('status')->default('Unapproved');
            $table->timestamps();

            $table->foreign('account_id')
                ->references('id')
                ->on('accounts')
                ->cascadeOnDelete();

            $table->foreign('expense_category_id')
                ->references('id')
                ->on('expense_categories')
                ->cascadeOnDelete();

            $table->foreign('payment_method_id')
                ->references('id')
                ->on('payment_methods')
                ->cascadeOnDelete();
        });

        Schema::create('payroll_contribution', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id');
            $table->foreignId('contribution_id');
            $table->foreignId('employee_id');
            $table->unsignedDecimal('amount', 10, 2);

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->cascadeOnDelete();

            $table->foreign('payroll_id')
                ->references('id')
                ->on('payrolls')
                ->cascadeOnDelete();

            $table->foreign('contribution_id')
                ->references('id')
                ->on('contributions')
                ->cascadeOnDelete();
        });

        Schema::create('payroll_tax', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id');
            $table->foreignId('tax_id');
            $table->foreignId('employee_id');
            $table->unsignedDecimal('amount', 10, 2);

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->cascadeOnDelete();

            $table->foreign('payroll_id')
                ->references('id')
                ->on('payrolls')
                ->cascadeOnDelete();

            $table->foreign('tax_id')
                ->references('id')
                ->on('taxes')
                ->cascadeOnDelete();
        });

        Schema::create('payroll_salary_benefit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payroll_id');
            $table->foreignId('salary_benefit_id');
            $table->foreignId('employee_id');
            $table->unsignedDecimal('amount', 10, 2);

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->cascadeOnDelete();

            $table->foreign('payroll_id')
                ->references('id')
                ->on('payrolls')
                ->cascadeOnDelete();

            $table->foreign('salary_benefit_id')
                ->references('id')
                ->on('salary_benefits')
                ->cascadeOnDelete();
        });

        Schema::create('employee_payroll', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->foreignId('payroll_id');
            $table->unsignedDecimal('salary', 10, 2);
            $table->unsignedDecimal('benefit', 10, 2)->default(0.00);
            $table->unsignedDecimal('deduction', 10, 2)->default(0.00);
            $table->unsignedDecimal('total_amount');

            $table->unique([
                'employee_id',
                'payroll_id'
            ]);

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->cascadeOnDelete();

            $table->foreign('payroll_id')
                ->references('id')
                ->on('payrolls')
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
        Schema::dropIfExists('payroll_contribution');
        Schema::dropIfExists('payroll_salary_benefit');
        Schema::dropIfExists('payroll_tax');
        Schema::dropIfExists('employee_payroll');
        Schema::dropIfExists('payrolls');
    }
}
