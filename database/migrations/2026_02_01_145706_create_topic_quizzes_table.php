<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topic_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('topic_attempts')->onDelete('cascade');
            $table->enum('type', ['multiple_choice', 'fill_in', 'essay']);
            $table->longText('question');
            $table->longText('answer')->nullable();
            $table->longText('answer_key')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topic_quizzes');
    }
};