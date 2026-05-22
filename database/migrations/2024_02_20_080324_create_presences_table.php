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
        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('training_match_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->boolean('present')->default(true);
            $table->boolean('announced_absent')->default(false);
            $table->boolean('unannounced_absent')->default(false);
            $table->string('reason')->nullable();
            $table->timestamps();
        });

        DB::table('presences')->insert(
            [
                [
                    'user_id' => 1,
                    'training_match_id' => 1,
                    'present' => true,
                    'announced_absent' => false,
                    'unannounced_absent' => false,
                    'reason' => null
                ],
                [
                    'user_id' => 1,
                    'training_match_id' => 2,
                    'present' => false,
                    'announced_absent' => true,
                    'unannounced_absent' => false,
                    'reason' => 'Ziek geworden'
                ],
                [
                    'user_id' => 1,
                    'training_match_id' => 3,
                    'present' => false,
                    'announced_absent' => true,
                    'unannounced_absent' => false,
                    'reason' => 'Nog altijd ziek'
                ],
                [
                    'user_id' => 1,
                    'training_match_id' => 4,
                    'present' => false,
                    'announced_absent' => false,
                    'unannounced_absent' => true,
                    'reason' => null
                ],
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
