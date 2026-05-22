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
        Schema::create('carpool_people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('carpool_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('amount');
            $table->timestamps();
        });

        DB::table('carpool_people')->insert(
            [
                [
                    'user_id' => 4,
                    'carpool_id' => 1,
                    'amount' => 1,

                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carpool_people');
    }
};
