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
        Schema::connection('mongodb')->create('individual_post_emojis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('individual_post_id');
            $table->integer('emoji_id')->index();
            $table->uuid('user_id');
            $table->index(['emoji_id', 'user_id']);
            $table->index(['emoji_id', 'individual_post_id']);
            $table->index(['user_id' => 'text', 'individual_post_id' => 'text'], 'post_full_text_index');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('individual_post_emojis');
    }
};
