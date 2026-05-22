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
        Schema::create('person_per_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('task_per_activity_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('reason')->nullable();
            $table->boolean('is_assigned')->default(false);
            $table->timestamps();
        });
        DB::table('person_per_tasks')->insert(
            [
                [
                    'user_id' => 2,
                    'task_per_activity_id' => 5, // truitjes wassen verplaatsing
                    'is_assigned' => true,
                ],
                [
                    'user_id' => 1,
                    'task_per_activity_id' => 1, // kassa
                    'is_assigned' => false,
                ],
                [
                    'user_id' => 1,
                    'task_per_activity_id' => 4, // opruimen
                    'is_assigned' => false,
                ],
                [
                    'user_id' => 3,
                    'task_per_activity_id' => 4, // opruimen
                    'is_assigned' => true,
                ],
                [
                    'user_id' => 2,
                    'task_per_activity_id' => 2, // truitjes wassen thuiswedstrijd
                    'is_assigned' => true,
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_per_tasks');
    }
};
