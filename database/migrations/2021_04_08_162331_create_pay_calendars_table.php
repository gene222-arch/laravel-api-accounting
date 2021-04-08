<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayCalendarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_calendars', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('type');
            $table->string('pay_day_mode');
            $table->timestamps();
        });

        Schema::create('employee_pay_calendar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pay_calendar_id');
            $table->foreignId('employee_id');

            $table->unique([
                'pay_calendar_id',
                'employee_id'
            ]);

            $table->foreign('pay_calendar_id')
                ->references('id')
                ->on('pay_calendars')
                ->cascadeOnDelete();

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
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
        Schema::dropIfExists('employee_pay_calendar');
        Schema::dropIfExists('pay_calendars');
    }
}
