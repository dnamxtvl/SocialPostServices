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
        Schema::connection('mysql_post')->create('individual_post_tags', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('individual_post_id')->fulltext();
            $table->tinyInteger('enable_notification')->default(config('individual_post_tags.enable_notification.turn_on'))->index();
            $table->uuid('user_id')->fulltext();
            $table->index(['user_id', 'enable_notification']);
            $table->index(['user_id', 'individual_post_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_post')->dropIfExists('individual_post_tags');
    }
};
