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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cover_photo_path', 2048);
            $table->timestamps();
        });

        DB::table('albums')->insert(
            [
                [
                    'name' => 'Seizoen 21/22',
                    'cover_photo_path' => '/storage/covers/album1.jpg'
                ],
                [
                    'name' => 'Seizoen 22/23',
                    'cover_photo_path' => '/storage/covers/album2.jpg'
                ],
                [
                    'name' => 'Seizoen 23/24',
                    'cover_photo_path' => '/storage/covers/album3.jpg'
                ]
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
