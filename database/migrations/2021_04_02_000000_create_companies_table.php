<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('name');
            $table->string('email');
            $table->char('tax_number', 11);
            $table->char('phone', 15);
            $table->string('address')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();

            $table->unique([
                'user_id',
                'name',
                'email',
                'tax_number',
                'phone'
            ], 
            'unique_user_id_name_email_tax_number_phone');

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
        Schema::dropIfExists('companies');
    }
}
