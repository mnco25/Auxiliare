<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('transactions');

        Schema::create('transactions', function (Blueprint $table) {
            $table->id('transaction_id');
            $table->unsignedBigInteger('investment_id')->nullable(); // Make nullable
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount', 10, 2);
            $table->enum('transaction_type', ['Investment', 'Milestone Payment', 'Refund', 'Deposit']); // Add Deposit type
            $table->timestamp('transaction_date')->useCurrent()->nullable();
            $table->enum('transaction_status', ['Pending', 'Success', 'Failed'])->default('Pending');
            $table->string('payment_gateway', 50)->nullable();
            $table->timestamps();

            $table->foreign('investment_id')->references('investment_id')->on('investments')->onDelete('cascade');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
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
