<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {

            $table->float("paidAmount")->nullable();
            $table->string("Currency")->nullable();
            $table->string("parentEmail")->nullable();
            $table->string("statusCode")->nullable();
            $table->timestamp("paymentDate")->nullable();
            $table->string("parentIdentification")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
