<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('account_status_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('previous_status');
            $table->string('new_status');
            $table->unsignedBigInteger('changed_by');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('changed_by')->references('user_id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('account_status_logs');
    }
};

