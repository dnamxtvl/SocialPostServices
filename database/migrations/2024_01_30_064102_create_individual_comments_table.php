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
        Schema::connection('mongodb')->create('individual_comments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('content')->index('text');
            $table->uuid('individual_post_id')->index('text');
            $table->uuid('user_id')->index('text');
            $table->uuid('parent_id')->nullable();
            $table->index(['user_id' => 'text', 'individual_post_id' => 'text']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('individual_comments');
    }
};
