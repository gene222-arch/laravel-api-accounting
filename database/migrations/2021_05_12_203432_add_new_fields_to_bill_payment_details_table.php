<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToBillPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bill_payment_details', function (Blueprint $table) {
            $table->foreignId('discount_id')->after('id')->default(1);
            $table->foreignId('tax_id')->after('id')->default(1);
            
            $table->foreign('discount_id')
                ->references('id')
                ->on('discounts')
                ->cascadeOnDelete();

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
        Schema::table('bill_payment_details', function (Blueprint $table) {
            //
        });
    }
}
