<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topic_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('topic_id')->constrained()->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->integer('total_attempts')->default(0);
            $table->float('best_grade')->nullable();
            $table->string('best_letter_grade')->nullable();
            $table->boolean('is_remidi')->default(false);
            $table->timestamps();

            $table->unique(['user_id', 'topic_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topic_progress');
    }
};