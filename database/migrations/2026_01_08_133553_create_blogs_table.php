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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            // Author who wrote the blog
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Blog content
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');

            // Blog workflow status
            $table->enum('status', [
                'draft',
                'pending',
                'approved',
                'scheduled',
                'published'
            ])->default('draft');

            // Scheduling & approval
            $table->timestamp('publish_at')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
