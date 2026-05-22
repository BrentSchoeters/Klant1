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
        Schema::create('parent_per_children', function (Blueprint $table) {
            $table->id();
            $table->foreignId('child_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('parent_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('cascade');

            $table->timestamps();
        });

        DB::table('parent_per_children')->insert(
            [
                [
                    'child_id' => 16,
                    'parent_id' => 2
                ],
                [
                    'child_id' => 17,
                    'parent_id' => 3
                ],
                [
                    'child_id' => 18,
                    'parent_id' => 4
                ],
                [
                    'child_id' => 19,
                    'parent_id' => 5
                ],
                [
                    'child_id' => 20,
                    'parent_id' => 6
                ],
                [
                    'child_id' => 21,
                    'parent_id' => 7
                ],
                [
                    'child_id' => 22,
                    'parent_id' => 8
                ],
                [
                    'child_id' => 23,
                    'parent_id' => 9
                ],
                [
                    'child_id' => 24,
                    'parent_id' => 2
                ],
                [
                    'child_id' => 25,
                    'parent_id' => 3
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parent_per_children');
    }
};
