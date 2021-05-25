<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('owner');
            $table->string('email');
            $table->string('phone');
            $table->string('stage');
            $table->string('mobile');
            $table->string('website');
            $table->string('fax_number');
            $table->string('source');
            $table->string('address');
            $table->timestamp('born_at')->default(now());
            $table->timestamps();

            $table->unique([
                'email',
                'phone',
                'fax_number',
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
        Schema::dropIfExists('contacts');
    }
}
