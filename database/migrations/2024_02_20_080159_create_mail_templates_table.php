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
        Schema::create('mail_templates', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('from');
            $table->string('to');
            $table->string('subject');
            $table->timestamps();
        });

        DB::table('mail_templates')->insert(
            [
                [
                    'path' => 'emails/weekplanning',
                    'from' => 'trainer',
                    'to' => 'delegees, trainers, ouders',
                    'subject' => 'Week planning',
                ],
                [
                    'path' => 'emails/trainerafwezig',
                    'from' => 'trainer',
                    'to' => 'ouders',
                    'subject' => 'trainer afwezig',
                ],
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_templates');
    }
};
