<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('topic_id')->constrained()->onDelete('cascade');
            $table->foreignId('attempt_id')->constrained('topic_attempts')->onDelete('cascade');
            $table->date('studied_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_logs');
    }
};