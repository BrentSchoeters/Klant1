<div>
    <div class="container mx-auto px-4">
        <section class="flex items-center justify-center my-10">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-2 text-gray-800">Welkom bij KVV Rauw</h1>
                <p class="text-lg md:text-xl leading-normal mt-2 text-gray-600">Welkom op de officiële webpagina van
                    KVV Rauw Sport Mol!</p>
            </div>
        </section>

        <section class="bg-gray-200 rounded-lg shadow-md p-8 my-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <section class="hero">
                    <div class="slideshow-container relative overflow-hidden">
                        <div class="mySlides fade relative w-full h-[400px]">
                            <img class="w-full h-full object-cover rounded-lg border-2 border-kvvrood" src="images/KVVRauwClubFoto.jpg"
                                 alt="Teamfoto KVV Rauw">
                            <div
                                class="text absolute bottom-0 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-80 text-white p-4 w-full text-center rounded-b-lg">
                                KVV Rauw: waar plezier en sportiviteit vooropstaan!
                            </div>
                        </div>
                        <div class="mySlides fade relative w-full h-[400px]">
                            <img class="w-full h-full object-cover rounded-lg border-2 border-kvvrood" src="images/KVVRauwTraining.jpg"
                                 alt="Spelers in actie">
                            <div
                                class="text absolute bottom-0 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-80 text-white p-4 w-full text-center rounded-b-lg">
                                Word lid van onze gezellige club en maak nieuwe vrienden!
                            </div>
                        </div>
                    </div>
                </section>

                <section class="about_us">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Ons Team</h2>
                        <p class="text-lg leading-relaxed mb-4">
                            Bij KVV Rauw U10 staat plezier in voetbal voorop! Onze enthousiaste spelers leren met volle
                            inzet en sportiviteit de kneepjes van het vak. Onder leiding van onze geduldige trainers
                            ontwikkelen ze zich zowel technisch als tactisch.
                        </p>
                        <ul class="list-disc list-inside">
                            <li>Wekelijkse trainingen</li>
                            <li>Competitiewedstrijden</li>
                            <li>Plezier voorop</li>
                        </ul>
                    </div>
                </section>
            </div>
        </section>

        <section class="bg-gray-200 rounded-lg shadow-md p-8 my-10">
            <div class="text-center mb-8">
                <h2 class="text-4xl font-bold mb-4 text-gray-800">Over KVV Rauw</h2>
                <p class="text-lg leading-relaxed text-gray-700">
                    KVV Rauw Sport Mol is meer dan alleen een voetbalclub. Het is een bloeiende gemeenschap waar spelers
                    van alle leeftijden samenkomen om hun passie voor voetbal te delen, nieuwe vriendschappen te sluiten
                    en onvergetelijke herinneringen te creëren.
                </p>
            </div>
            <div class="text-center mb-8">
                <h2 class="text-4xl font-bold mb-4 text-gray-800">Word lid van onze familie!</h2>
                <p class="text-lg leading-relaxed text-gray-700">
                    Ben je op zoek naar een leuke en uitdagende manier om te sporten? Wil je deel uitmaken van een
                    hechte gemeenschap van gelijkgestemde individuen? Sluit je dan vandaag nog aan bij KVV Rauw Sport
                    Mol! Kom langs voor een training of neem contact met ons op voor meer informatie.
                </p>
                <div class="text-center mt-5">
                    <x-tmk.form.button style="height: 50px" type="button" color="dashboard" wire:navigate
                                       href="{{ route('register') }}">
                        Schrijf je nu in!
                    </x-tmk.form.button>
                </div>
            </div>
        </section>

        <section class="bg-gray-200 rounded-lg shadow-md p-8 my-10">
            <div class="text-center mb-8">
                <h2 class="text-4xl font-bold mb-4 text-gray-800">Komende Wedstrijden</h2>
                <p class="text-lg leading-relaxed text-gray-700">
                    Bekijk hieronder de komende wedstrijden van KVV Rauw Sport Mol.
                </p>
            </div>
            @if ($nextMatches->isEmpty())
                <p class="text-gray-700 text-center">Er zijn momenteel geen aankomende wedstrijden.</p>
            @else
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    @foreach ($nextMatches as $nextMatch)
                        <div
                            class="bg-white rounded-lg border-2 border-kvvrood shadow-md p-6 flex flex-col justify-center">
                            <div class="font-bold text-center">
                                @if($nextMatch->home === 1)
                                    <h2>KVV Rauw vs {{$nextMatch->opponent}}</h2>
                                @else
                                    <h2>{{$nextMatch->opponent}} vs KVV Rauw</h2>
                                @endif
                            </div>
                            <div class="flex items-center mb-2">
                                <x-phosphor-calendar class="h-5 w-5 mr-2"/>
                                <span
                                    class="text-lg font-medium text-gray-700">{{ \Carbon\Carbon::parse($nextMatch->date)->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center mb-2">
                                <x-phosphor-clock class="h-5 w-5 mr-2"/>
                                <span
                                    class="text-lg font-medium text-gray-700">{{ \Carbon\Carbon::parse($nextMatch->start)->format('H:i') }}</span>
                            </div>
                            <div class="flex items-center mb-2">
                                <x-phosphor-map-pin class="h-5 w-5 mr-2"/>
                                <span class="text-lg font-medium text-gray-700">{{ $nextMatch->address }}: Veld {{ $nextMatch->field }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>
    <x-slot name="footerName">
        Lucas Vanden Heede
    </x-slot>

    <script>
        let slideIndex = 0;

        document.addEventListener("DOMContentLoaded", function () {
            showSlides();
        });

        function showSlides() {
            let slides = document.getElementsByClassName("mySlides");
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }
            slides[slideIndex - 1].style.display = "block";
            setTimeout(showSlides, 10000);
        }
    </script>
</div>
