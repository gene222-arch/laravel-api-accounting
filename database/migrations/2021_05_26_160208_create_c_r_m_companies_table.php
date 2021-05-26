<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCRMCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crm_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('owner');
            $table->string('email');
            $table->string('phone');
            $table->string('stage');
            $table->string('mobile');
            $table->string('website');
            $table->string('fax_number')->nullable();
            $table->string('source');
            $table->string('address');
            $table->timestamp('born_at')->default(now());
            $table->boolean('enabled')->default(false);
            $table->timestamps();

            $table->unique([
                'email',
                'phone',
                'fax_number',
            ]);
        });

        Schema::create('crm_company_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crm_company_id');
            $table->text('note');
            $table->timestamps();

            $table->foreign('crm_company_id')
                ->references('id')
                ->on('crm_companies')
                ->cascadeOnDelete();
        });

        Schema::create('crm_company_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crm_company_id');
            $table->timestamp('date');
            $table->time('time');
            $table->string('log');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('crm_company_id')
                ->references('id')
                ->on('crm_companies')
                ->cascadeOnDelete();
        });

        Schema::create('crm_company_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crm_company_id');
            $table->foreignId('user_id');
            $table->string('name')->unique();
            $table->string('log');
            $table->timestamp('started_at')->default(now());
            $table->timestamp('ended_at')->default(now());
            $table->time('time_started');
            $table->time('time_ended');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('crm_company_id')
                ->references('id')
                ->on('crm_companies')
                ->cascadeOnDelete();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });

        Schema::create('crm_company_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crm_company_id');
            $table->foreignId('user_id');
            $table->string('name')->unique();
            $table->timestamp('started_at')->default(now());
            $table->time('time_started');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('crm_company_id')
                ->references('id')
                ->on('crm_companies')
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
        Schema::dropIfExists('crm_company_notes');
        Schema::dropIfExists('crm_company_logs');
        Schema::dropIfExists('crm_company_schedules');
        Schema::dropIfExists('crm_company_tasks');
        Schema::dropIfExists('crm_companies');
    }
}
