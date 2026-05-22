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
        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->string('size');
            $table->timestamps();
        });

        DB::table('sizes')->insert(
            [
                ['size' => 'xxs'],
                ['size' => 'xs'],
                ['size' => 's'],
                ['size' => 'm'],
                ['size' => 'l'],
                ['size' => '33-36'],
                ['size' => '37-40'],
                ['size' => '41-43']
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sizes');
    }
};
