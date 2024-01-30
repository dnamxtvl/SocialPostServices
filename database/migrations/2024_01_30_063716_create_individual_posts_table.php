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
        Schema::connection('mysql_post')->create('individual_posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->fulltext();
            $table->tinyInteger('scope')->default(config('individual_posts.scope.public'))->index();
            $table->tinyInteger('enable_notification')->default(config('individual_posts.enable_notification.turn_on'))->index();
            $table->uuid('user_id')->fulltext();
            $table->integer('city_id')->nullable()->index();
            $table->boolean('is_pin')->default(config()->get('individual_posts.pin.not_pin'));
            $table->tinyInteger('scope_comment')->default(config('individual_posts.scope_comment.public'))->index();
            $table->index(['user_id', 'city_id']);
            $table->index(['user_id', 'is_pin']);
            $table->index(['user_id', 'enable_notification']);
            $table->index(['user_id', 'scope_comment']);
            $table->index(['user_id', 'scope']);
            $table->index('created_at');
            $table->index(['user_id', 'created_at']);
            $table->index(['scope', 'scope_comment']);
            $table->index(['scope', 'enable_notification']);
            $table->index(['scope_comment', 'enable_notification']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_post')->dropIfExists('individual_posts');
    }
};
