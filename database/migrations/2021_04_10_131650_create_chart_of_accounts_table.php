<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartOfAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chart_of_account_type_id');
            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            $table->boolean('enabled')->default(false);
            $table->timestamps();

            $table->unique([
                'name',
                'code'
            ]);

            $table->foreign('chart_of_account_type_id')
                ->references('id')
                ->on('chart_of_account_types')
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
        Schema::dropIfExists('chart_of_accounts');
    }
}
