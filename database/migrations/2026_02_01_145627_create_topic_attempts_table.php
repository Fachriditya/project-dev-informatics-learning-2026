<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topic_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_id')->constrained()->onDelete('cascade');
            $table->integer('attempt_ke')->default(1);
            $table->string('content')->nullable();
            $table->longText('review')->nullable();
            $table->float('grade')->nullable();
            $table->string('letter_grade')->nullable();
            $table->boolean('is_passed')->default(false);
            $table->string('refleksi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topic_attempts');
    }
};