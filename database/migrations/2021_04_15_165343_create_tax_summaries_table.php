<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_summaries', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->foreignId('model_id');
            $table->foreignId('tax_id');
            $table->unsignedDecimal('amount', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('tax_id')
                ->references('id')
                ->on('taxes')
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
        Schema::dropIfExists('tax_summaries');
    }
}
