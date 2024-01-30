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
        Schema::connection('mongodb')->create('individual_media_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('path');
            $table->string('name');
            $table->tinyInteger('type')->index();
            $table->boolean('is_album')->default(config('individual_media_files.is_album'))->index();
            $table->uuid('individual_album_id')->nullable()->index('text');
            $table->index(['type' => 1, 'is_album' => 1], 'type_is_album_index', 'type_is_album_index');
            $table->index(['is_album' => 1, 'individual_album_id' => 'text'], 'is_album_individual_album_id_index');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('individual_media_files');
    }
};
