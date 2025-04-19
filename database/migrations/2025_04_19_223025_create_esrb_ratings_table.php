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
        Schema::create('esrb_ratings', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10); // E, E10+, T, M, AO, etc.
            $table->string('name', 50); // "Everyone", "Teen", etc.
            $table->text('description')->nullable(); // Description of the rating
            $table->timestamps();
        });

        // Add foreign key to video_games table
        Schema::table('video_games', function (Blueprint $table) {
            $table->foreignId('esrb_rating_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // First drop the foreign key
        Schema::table('video_games', function (Blueprint $table) {
            $table->dropConstrainedForeignId('esrb_rating_id');
        });

        Schema::dropIfExists('esrb_ratings');
    }
};