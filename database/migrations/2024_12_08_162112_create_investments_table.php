<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('investments');

        Schema::create('investments', function (Blueprint $table) {
            $table->id('investment_id');
            $table->unsignedBigInteger('investor_id');
            $table->unsignedBigInteger('project_id');
            $table->decimal('investment_amount', 10, 2);
            $table->timestamp('investment_date')->useCurrent()->nullable();
            $table->enum('investment_status', ['Pending', 'Confirmed', 'Refunded'])->default('Pending');
            $table->timestamps();

            $table->foreign('investor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

            $table->index('investment_status', 'idx_investment_status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('investments');
    }
}