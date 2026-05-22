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
        Schema::create('training_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->date('date');
            $table->time('start');
            $table->time('end')->nullable();
            $table->string('address');
            $table->boolean('home');
            $table->string('field');
            $table->boolean('is_match');
            $table->string('opponent')->nullable();
            $table->string('preparation')->nullable();
            $table->boolean('active')->default(true);
            $table->string('preparation_photo_path', 2048)->nullable();
            $table->timestamps();
        });

        DB::table('training_matches')->insert(
            [
                [
                    'user_id' => 1,
                    'date' => '2024-06-24',
                    'start' => '09:30',
                    'end' => null,
                    'address' => 'Sportpark 10 Brasel 34 , 2480 Dessel',
                    'Home' => true,
                    'field' => 1,
                    'is_match' => true,
                    'preparation' => null,
                    'opponent' => 'Verb. Balen',
                    'active' => true,
                    'preparation_photo_path' => null,
                ],
                [
                    'user_id' => null,
                    'date' => '2024-02-26',
                    'start' => '18:00',
                    'end' => '19:30',
                    'address' => 'Blekestraat 40, 2400 Mol',
                    'Home' => true,
                    'field' => 3,
                    'is_match' => false,
                    'preparation' => null,
                    'opponent' => null,
                    'active' => true,
                    'preparation_photo_path' => null,
                ],
                [
                    'user_id' => null,
                    'date' => '2024-02-28',
                    'start' => '18:00',
                    'end' => '19:30',
                    'address' => 'Blekestraat 40, 2400 Mol',
                    'Home' => true,
                    'field' => 3,
                    'is_match' => false,
                    'preparation' => null,
                    'opponent' => null,
                    'active' => true,
                    'preparation_photo_path' => null,
                ],
                [
                    'user_id' => 1,
                    'date' => '2024-06-18',
                    'start' => '10:00',
                    'end' => null,
                    'address' => 'Blekestraat 40, 2400 Mol',
                    'Home' => false,
                    'field' => 2,
                    'is_match' => true,
                    'preparation' => null,
                    'opponent' => 'Wezel Sport',
                    'active' => true,
                    'preparation_photo_path' => null,
                ],
                [
                    'user_id' => null,
                    'date' => '2024-02-26',
                    'start' => '18:00',
                    'end' => '19:30',
                    'address' => 'Blekestraat 40, 2400 Mol',
                    'Home' => true,
                    'field' => 3,
                    'is_match' => false,
                    'preparation' => null,
                    'opponent' => null,
                    'active' => true,
                    'preparation_photo_path' => null,
                ],
                [
                    'user_id' => null,
                    'date' => '2024-02-28',
                    'start' => '18:00',
                    'end' => '19:30',
                    'address' => 'Blekestraat 40, 2400 Mol',
                    'Home' => true,
                    'field' => 3,
                    'is_match' => false,
                    'preparation' => null,
                    'opponent' => null,
                    'active' => true,
                    'preparation_photo_path' => null,
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_matches');
    }
};
