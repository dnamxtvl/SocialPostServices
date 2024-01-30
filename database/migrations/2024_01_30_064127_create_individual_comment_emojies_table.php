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
        Schema::connection('mysql_post')->create('individual_comment_emojis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('individual_comment_id')->fulltext();
            $table->integer('emoji_id')->index();
            $table->uuid('user_id')->fulltext();
            $table->index(['user_id', 'individual_comment_id']);
            $table->index(['individual_comment_id', 'emoji_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_post')->dropIfExists('individual_comment_emojis');
    }
};
