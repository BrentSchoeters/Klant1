<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clothing_per_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('clothing_size_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });

        DB::table('clothing_per_players')->insert(
            [
                [
                    'user_id' => 16,
                    'clothing_size_id' => 3,
                ],
                [
                    'user_id' => 16,
                    'clothing_size_id' => 8,
                ],
                [
                    'user_id' => 16,
                    'clothing_size_id' => 11,
                ],
                [
                    'user_id' => 17,
                    'clothing_size_id' => 1,
                ],
                [
                    'user_id' => 17,
                    'clothing_size_id' => 6,
                ],
                [
                    'user_id' => 17,
                    'clothing_size_id' => 12,
                ],
                [
                    'user_id' => 18,
                    'clothing_size_id' => 2,
                ],
                [
                    'user_id' => 18,
                    'clothing_size_id' => 7,
                ],
                [
                    'user_id' => 18,
                    'clothing_size_id' => 13,
                ],
                [
                    'user_id' => 19,
                    'clothing_size_id' => 4,
                ],
                [
                    'user_id' => 19,
                    'clothing_size_id' => 6,
                ],
                [
                    'user_id' => 19,
                    'clothing_size_id' => 11,
                ],
                [
                    'user_id' => 20,
                    'clothing_size_id' => 5,
                ],
                [
                    'user_id' => 20,
                    'clothing_size_id' => 9,
                ],
                [
                    'user_id' => 20,
                    'clothing_size_id' => 11,
                ],
                [
                    'user_id' => 21,
                    'clothing_size_id' => 3,
                ],
                [
                    'user_id' => 21,
                    'clothing_size_id' => 8,
                ],
                [
                    'user_id' => 21,
                    'clothing_size_id' => 11,
                ],
                [
                    'user_id' => 22,
                    'clothing_size_id' => 3,
                ],
                [
                    'user_id' => 22,
                    'clothing_size_id' => 8,
                ],
                [
                    'user_id' => 22,
                    'clothing_size_id' => 11,
                ],
                [
                    'user_id' => 23,
                    'clothing_size_id' => 3,
                ],
                [
                    'user_id' => 23,
                    'clothing_size_id' => 8,
                ],
                [
                    'user_id' => 23,
                    'clothing_size_id' => 11,
                ],
                [
                    'user_id' => 24,
                    'clothing_size_id' => 3,
                ],
                [
                    'user_id' => 24,
                    'clothing_size_id' => 8,
                ],
                [
                    'user_id' => 24,
                    'clothing_size_id' => 11,
                ],
                [
                    'user_id' => 25,
                    'clothing_size_id' => 3,
                ],
                [
                    'user_id' => 25,
                    'clothing_size_id' => 8,
                ],
                [
                    'user_id' => 25,
                    'clothing_size_id' => 11,
                ]
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clothing_per_players');
    }
};
