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
        Schema::create('carpools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('training_match_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('amount');
            $table->time('time');
            $table->string('address');
            $table->timestamps();
        });

        DB::table('carpools')->insert(
            [
                [
                    'user_id' => 3,
                    'training_match_id' => 1,
                    'amount' => 3,
                    'time' => '09:00',
                    'address' => 'parking van K.V.V. Rauw '
                ],
                [
                    'user_id' => 2,
                    'training_match_id' => 3,
                    'amount' => 4,
                    'time' => '09:00',
                    'address' => 'parking van K.V.V. Rauw '
                ],
                [
                    'user_id' => 5,
                    'training_match_id' => 3,
                    'amount' => 5,
                    'time' => '09:00',
                    'address' => 'parking van K.V.V. Rauw '
                ],
                [
                    'user_id' => 2,
                    'training_match_id' => 3,
                    'amount' => 3,
                    'time' => '09:00',
                    'address' => 'parking van K.V.V. Rauw '
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carpools');
    }
};
