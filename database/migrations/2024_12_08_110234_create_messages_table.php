<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id('message_id');
            $table->foreignId('sender_id')->constrained('users', 'user_id');
            $table->foreignId('receiver_id')->constrained('users', 'user_id');
            $table->foreignId('project_id')->nullable()->constrained('projects');
            $table->text('message_content');
            $table->timestamp('sent_at')->useCurrent();
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->index(['sender_id', 'receiver_id', 'project_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
