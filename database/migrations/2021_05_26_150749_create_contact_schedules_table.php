<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id');
            $table->foreignId('user_id');
            $table->string('name')->unique();
            $table->string('log');
            $table->timestamp('started_at')->default(now());
            $table->timestamp('ended_at')->default(now());
            $table->time('time_started');
            $table->time('time_ended');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('contact_id')
                ->references('id')
                ->on('contacts')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('contact_schedules');
    }
}
