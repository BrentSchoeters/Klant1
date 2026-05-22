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
        Schema::create('clothing_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clothing_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('size_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });

        DB::table('clothing_sizes')->insert(
            [
                [
                    'clothing_id' => 1,
                    'size_id' => 1,
                ],
                [
                    'clothing_id' => 1,
                    'size_id' => 2,
                ],
                [
                    'clothing_id' => 1,
                    'size_id' => 3,
                ],
                [
                    'clothing_id' => 1,
                    'size_id' => 4,
                ],
                [
                    'clothing_id' => 1,
                    'size_id' => 5,
                ],
                [
                    'clothing_id' => 2,
                    'size_id' => 1,
                ],
                [
                    'clothing_id' => 2,
                    'size_id' => 2,
                ],
                [
                    'clothing_id' => 2,
                    'size_id' => 3,
                ],
                [
                    'clothing_id' => 2,
                    'size_id' => 4,
                ],
                [
                    'clothing_id' => 2,
                    'size_id' => 5,
                ],
                [
                    'clothing_id' => 3,
                    'size_id' => 6,
                ],
                [
                    'clothing_id' => 3,
                    'size_id' => 7,
                ],
                [
                    'clothing_id' => 3,
                    'size_id' => 8,
                ]
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clothing_sizes');
    }
};
