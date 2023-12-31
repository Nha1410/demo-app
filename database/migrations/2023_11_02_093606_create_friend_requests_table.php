<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('friend_requests', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sender_id'); // relation to user_id
            $table->bigInteger('receiver_id'); // relation to user_id
            $table->integer('status')->comment('1:pending, 2:accepted, 3:declined');  // (trạng thái yêu cầu: pending, accepted, declined, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('friend_requests');
    }
};
