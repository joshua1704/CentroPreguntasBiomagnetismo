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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('question');
            $table->text('answer')->nullable();
            $table->enum('status', ['pending', 'answered', 'published', 'archived', 'deleted']);
            $table->timestamps();
            $table->foreignId('topic_id')->constrained('topics');
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
