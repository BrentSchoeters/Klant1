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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->boolean('payed')->default(false);
            $table->string('season');
            $table->timestamps();
        });

        DB::table('registrations')->insert(
            [
                [
                    'user_id' => 16,
                    'payed' => true,
                    'season' => '2023/2024'
                ],
                [
                    'user_id' => 17,
                    'payed' => true,
                    'season' => '2023/2024'
                ],
                [
                    'user_id' => 18,
                    'payed' => false,
                    'season' => '2023/2024'
                ],
                [
                    'user_id' => 19,
                    'payed' => false,
                    'season' => '2023/2024'
                ],
                [
                    'user_id' => 20,
                    'payed' => true,
                    'season' => '2023/2024'
                ],
                [
                    'user_id' => 21,
                    'payed' => false,
                    'season' => '2023/2024'
                ],
                [
                    'user_id' => 22,
                    'payed' => true,
                    'season' => '2023/2024'
                ],
                [
                    'user_id' => 23,
                    'payed' => true,
                    'season' => '2023/2024'
                ],
                [
                    'user_id' => 24,
                    'payed' => true,
                    'season' => '2023/2024'
                ],
                [
                    'user_id' => 25,
                    'payed' => false,
                    'season' => '2023/2024'
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
