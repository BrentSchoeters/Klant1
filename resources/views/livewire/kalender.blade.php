<div>
    <!-- In de HTML-sectie van je code -->
{{--    <input type="hidden" id="selected-event-id" wire:model="selectedEventId">--}}
    <div class="max-h-screen" id='calendar' wire:ignore></div>
    <input type="hidden" id="event-id" value="eventid">
    <div>
        @if($eventDetails)
            <div class="flex ">
                <div class="flex flex-col w-4/12">
                    <h2 class="w-full">Extra info:</h2>
                    <p class="w-full">Address: {{ $eventDetails->address }}</p>
                    <p class="w-full">Datum: {{ $eventDetails->date}}</p>
                    <p class="mb-5 w-full">Tijd: {{ $eventDetails->start }} - {{ $eventDetails->end }}</p>

                    <h2 class="w-full">Aanwezige Trainers:</h2>
                    <ul>
                        @foreach($eventDetails->presences as $presence)
                           @if($presence->user->role_id === 1 && $presence->present)
                                <li>{{ $presence->user->firstname }} {{ $presence->user->surname }}</li>
                               @break

                            @else
                                <li>Geen trainers aanwezig.</li>
                               @break
                            @endif
                        @endforeach
                    </ul>
                </div>

                <!-- Voeg hier andere benodigde informatie toe -->
                <div class="flex">

                    @if(in_array($userRole, [1, 2, 4, 5])) <!-- Role ID 3 for parent -->
                        <x-tmk.form.button type="button" color="dashboard" wire:click="setPlayerAbsent()" class="m-4 h-1/2">afwezigheid kind melden</x-tmk.form.button>
                    @endif


                    @if(in_array($userRole, [1, 2, 5])) <!-- Role IDs for trainer, delegee, and admin -->
                        <x-tmk.form.button type="button" color="dashboard" wire:click="editPresence()" class="m-4 h-1/2">Aanwezigheden</x-tmk.form.button>
                        <x-tmk.form.button type="button" color="dashboard" wire:click="setTrainerAbsent()" class="m-4 h-1/2">Trainer afwezig</x-tmk.form.button>
                    @endif
                </div>


            </div>
        @endif


            {{-- Modal spelers --}}
            <x-dialog-modal wire:model.live="showModal" class="border-2 border-kvvrood">
                <x-slot name="title">
                    <h2>Aanwezigheden</h2>
                </x-slot>
                <x-slot name="content">
                    @if ($errors->any())
                        <x-tmk.alert type="danger">
                            <x-tmk.list>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </x-tmk.list>
                        </x-tmk.alert>
                    @endif
                    <h2></h2>
                    <table class="table-fixed w-full">
                        <thead>
                        <tr>
                            <th class="w-1/4">Speler</th>
                            <th class="w-1/4">Aanwezig</th>
                            <th class="w-1/4">Aangekondigd Afwezig</th>
                            <th class="w-1/4">Onaangekondigd Afwezig</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($eventDetails)
                            @foreach($eventDetails->presences as $index => $presence)
                                <tr>
                                    <td>{{ $presence->user->firstname }} {{ $presence->user->surname }}</td>
                                    <td style="text-align: center;">
                                        <!-- Checkbox voor aanwezigheid -->
                                        <label>
                                            <input type="radio" name="presence_{{$index}}"  wire:click="updatePresence({{ $presence->id }}, true, false, false)" {{ $presence->present ? 'checked' : '' }}>
                                        </label>
                                    </td>
                                    <td style="text-align: center;">
                                        <!-- Checkbox voor aangekondigde afwezigheid -->
                                        <label>
                                            <input type="radio" name="presence_{{$index}}"  wire:click="updatePresence({{ $presence->id }}, false, true, false)" {{ $presence->announced_absent ? 'checked' : '' }}>
                                        </label>
                                        @if($presence->announced_absent)
                                            @if($presence->reason)
                                                <p>Reden: {{ $presence->reason }}</p>
                                            @else
                                                <p>Geen reden opgegeven.</p>
                                            @endif
                                        @endif
                                    </td>
                                    <td style="text-align: center;">
                                        <!-- Checkbox voor onaangekondigde afwezigheid -->
                                        <label>
                                            <input type="radio" name="presence_{{$index}}" wire:click="updatePresence({{ $presence->id }}, false, false, true)" {{ $presence->unannounced_absent ? 'checked' : '' }}>
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                </x-slot>
                <x-slot name="footer">
                    <x-tmk.form.button color="annuleren" @click="$wire.showModal = false">Annuleren</x-tmk.form.button>
                    <x-tmk.form.button color="toevoegen" @click="$wire.showModal = false" class="ml-2">Veranderingen opslaan</x-tmk.form.button>
                </x-slot>
            </x-dialog-modal>

            {{-- Modal afwezig melden spelers --}}
            <x-dialog-modal wire:model.live="showModalSpeler" class="border-2 border-kvvrood">
                <x-slot name="title">
                    <h2 class="text-lg font-semibold">Afwezigheid melden</h2>
                </x-slot>
                <x-slot name="content">
                    <div class="space-y-4">
                        <div>
                            <label for="child" class="block text-sm font-medium text-gray-700">Kind:</label>
                            <select wire:model="selectedChildId" id="child" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecteer een kind</option>
                                @foreach($children as $child)
                                    <option value="{{ $child->id }}">{{ $child->firstname }} {{ $child->surname }}</option>
                                @endforeach
                            </select>
                            @error('selectedChildId') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="reason" class="block text-sm font-medium text-gray-700">Reden van afwezigheid:</label>
                            <input type="text" id="reason" wire:model="reason" placeholder="Reden van afwezigheid" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('reason') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <div class="flex justify-end space-x-2">
                        <x-tmk.form.button color="annuleren" @click="$wire.showModalSpeler = false">Annuleren</x-tmk.form.button>
                        <x-tmk.form.button color="toevoegen" wire:click="reportAbsencePlayer()" class="ml-2">Afwezig melden</x-tmk.form.button>
                    </div>
                </x-slot>
            </x-dialog-modal>

            {{-- Modal afwezig melden trainer --}}
            <x-dialog-modal wire:model.live="showModalTrainer" class="border-2 border-kvvrood">
                <x-slot name="title">
                    <h2 class="text-lg font-semibold">Afwezigheid melden</h2>
                </x-slot>
                <x-slot name="content">
                    <div class="space-y-4">

                        <div>
                            <label for="reason" class="block text-sm font-medium text-gray-700">Reden van afwezigheid:</label>
                            <input type="text" id="reason" wire:model="reason" placeholder="Reden van afwezigheid" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('reason') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <div class="flex justify-end space-x-2">
                        <x-tmk.form.button color="annuleren" @click="$wire.showModalTrainer = false">Annuleren</x-tmk.form.button>
                        <x-tmk.form.button color="toevoegen" wire:click="reportAbsenceTrainer()" class="ml-2">Afwezig melden</x-tmk.form.button>
                    </div>
                </x-slot>
            </x-dialog-modal>
    </div>
    @push('script')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
        <script>

            // In de JavaScript-sectie van je code
            document.addEventListener('DOMContentLoaded', function() {
                let calendarEl = document.getElementById('calendar');
                let calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    firstDay: 1,
                    fixedWeekCount: false,
                    lang: 'be',
                    events: <?php echo json_encode($events); ?>,
                    eventClick: function(info) {
                        // Controleer of het info-object een event bevat
                        if (info.event) {
                            let eventId = parseInt(info.event.id);
                            // Roep de Livewire-methode aan om de event-details op te halen
                            try {
                                Livewire.dispatch('process-event', {event_id: eventId});
                                // Livewire.dispatch('process-event');
                            } catch (error) {
                                console.error('Er is een fout opgetreden bij het verzenden van het evenement:', error);
                            }
                            console.log('Geselecteerde event ID:', eventId);
                        }
                    }
                });
                calendar.render();
            });

        </script>

    @endpush
    <x-slot name="footerName">
        Cisse Vandeweyer
    </x-slot>
</div>
