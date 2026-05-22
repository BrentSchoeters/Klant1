<!-- resources/views/livewire/event-details.blade.php -->
<div>
    @if($eventDetails)
        <div>
            <p>Address: {{ $eventDetails->address }}</p>
            <p>Datum: {{ $eventDetails->date }}</p>
            <p>Tijd: {{ $eventDetails->start }} - {{ $eventDetails->end }}</p>
            <!-- Voeg hier andere benodigde informatie toe -->
        </div>
    @endif

</div>

