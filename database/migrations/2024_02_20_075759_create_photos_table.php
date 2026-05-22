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
        Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->text('info')->nullable();
            $table->string('photo_path', 2048);
            $table->timestamps();
        });

        DB::table('photos')->insert(
            [
                [
                    'album_id' => 1,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => 'Hier zien we de U10 die aan het helpen zijn op ons jaarlijks mosselfeest.'
                ],
                [
                    'album_id' => 1,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => null
                ],
                [
                    'album_id' => 1,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => null
                ],
                [
                    'album_id' => 1,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => null
                ],
                [
                    'album_id' => 1,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => null
                ],
                [
                    'album_id' => 2,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => 'Het winnen van de eerste voetbalwedstrijd is een mijlpaal die elke speler, coach en fan zich nog lang zal herinneren. De voorbereidingen beginnen weken, zo niet maanden, van tevoren. Spelers trainen dagelijks, tactieken worden verfijnd, en de teamgeest wordt opgebouwd. Al deze inspanningen hebben maar één doel: winnen.',
                ],
                [
                    'album_id' => 2,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => null
                ],
                [
                    'album_id' => 2,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => null
                ],
                [
                    'album_id' => 3,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => null
                ],
                [
                    'album_id' => 3,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => null
                ],
                [
                    'album_id' => 3,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => null
                ],
                [
                    'album_id' => 3,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => null
                ],
                [
                    'album_id' => 3,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => null
                ],
                [
                    'album_id' => 3,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => 'Het winnen van de eerste voetbalwedstrijd is een mijlpaal die elke speler, coach en fan zich nog lang zal herinneren. De voorbereidingen beginnen weken, zo niet maanden, van tevoren. Spelers trainen dagelijks, tactieken worden verfijnd, en de teamgeest wordt opgebouwd. Al deze inspanningen hebben maar één doel: winnen.
                                Als de grote dag dan eindelijk aanbreekt, is de spanning voelbaar. De kleedkamers gonzen van de zenuwen en anticipatie. Spelers overlopen in hun hoofd de strategieën die ze talloze keren hebben geoefend. Dan, als de fluit klinkt, is het tijd om alles wat ze geleerd hebben in praktijk te brengen.
                                Het spel zelf is een achtbaan van emoties. Elk doelpunt, elke pass, en elke redding voegt toe aan de oplopende spanning. De fans juichen bij elke geslaagde beweging en leven intens mee met elke gemiste kans. En dan, als het eindsignaal klinkt en het team heeft gewonnen, barst het stadion uit in een ongekende vreugde.
                                De spelers omhelzen elkaar. Ze hebben samengewerkt, gestreden, en uiteindelijk samen de overwinning behaald. De coach prijst hun inzet en moed. Deze eerste overwinning is niet alleen een trofee; het is een bewijs van hun harde werk, een bevestiging dat ze op de goede weg zijn, en een impuls die hen motiveert voor toekomstige wedstrijden.
                                Voor de supporters is het een moment van pure blijdschap en trots. Hun steun wordt beloond met een schitterende prestatie. Deze wedstrijd zal worden besproken en herinnerd als het begin van iets speciaals, een moment waarop potentieel werd omgezet in succes.
                                Deze eerste overwinning is meer dan een spelresultaat; het is een hoofdstuk in de geschiedenis van het team dat de fundering legt voor de mentaliteit en cultuur. Het is een verhaal van vastberadenheid, passie en triomf dat nog jarenlang zal resoneren, zowel binnen als buiten het veld'
                ],
                [
                    'album_id' => 3,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => null
                ],
                [
                    'album_id' => 3,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => null
                ],
                [
                    'album_id' => 3,
                    'photo_path' => '/storage/photos/test.jpg',
                    'info' => null
                ]
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
