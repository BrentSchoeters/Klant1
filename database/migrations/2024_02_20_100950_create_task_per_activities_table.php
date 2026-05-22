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
        Schema::create('task_per_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_match_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('task_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->integer('amount');
            $table->timestamps();
        });

        DB::table('task_per_activities')->insert(
            [
                [
                    'training_match_id' => 1,
                    'task_id' => 1,
                    'amount' => 2,
                ],
                [
                    'training_match_id' => 1,
                    'task_id' => 2,
                    'amount' => 1,
                ],
                [
                    'training_match_id' => 1,
                    'task_id' => 3,
                    'amount' => 2,
                ],
                [
                    'training_match_id' => 1,
                    'task_id' => 4,
                    'amount' => 2,
                ],
                [
                    'training_match_id' => 4,
                    'task_id' => 2,
                    'amount' => 1,
                ],

            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_per_activities');
    }
};
