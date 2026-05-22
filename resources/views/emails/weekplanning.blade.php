<h1>Weekplanning KVV Rauw [Week: {{$currentWeekNumber}}]</h1>
<p>Beste {{$receiver->firstname}},</p>
<p>Hierbij de weekplanning voor deze week:</p>

<h3>Matches:</h3>
<ul>
    @foreach($matches as $match)
        @if($match->home === 1)
            <p>KVV Rauw vs {{$match->opponent}}</p>
        @else
            <p>{{ $match->opponent }} vs KVV Rauw</p>
        @endif
        <li>Datum: {{ \Carbon\Carbon::parse($match->date)->format('d/M/Y') }}</li>
        <li>Start: {{ \Carbon\Carbon::parse($match->start)->format('H:i') }}</li>
        <li>Address: {{ $match->address }}: Veld {{ $match->field }}</li>
    @endforeach
</ul>

<h3>Trainings:</h3>
<ul>
    @foreach($trainings as $training)
        <li>Datum: {{ \Carbon\Carbon::parse($training->date)->format('d/M/Y') }}</li>
        <li>Time: {{ \Carbon\Carbon::parse($training->start)->format('H:i') }} - {{ \Carbon\Carbon::parse($training->end)->format('H:i') }}</li>
        <li>Address: {{ $training->address }}: Veld {{ $training->field }}</li>
    @endforeach
</ul>

<h3>Taken:</h3>
<ul>
    <li><strong>Kassa:</strong>
        <ul>
            @foreach($taskPersons as $taskPerson)
                @if($taskPerson->task_per_activity_id === 1)
                    <li>{{ $taskPerson->user->firstname }} {{ $taskPerson->user->surname }}</li>
                @endif
            @endforeach
        </ul>
    </li>
    <li><strong>Kledij wassen:</strong>
        <ul>
            @foreach($taskPersons as $taskPerson)
                @if($taskPerson->task_per_activity_id === 2)
                    <li>{{ $taskPerson->user->firstname }} {{ $taskPerson->user->surname }}</li>
                @endif
            @endforeach
        </ul>
    </li>
    <li><strong>Toog:</strong>
        <ul>
            @foreach($taskPersons as $taskPerson)
                @if($taskPerson->task_per_activity_id === 3)
                    <li>{{ $taskPerson->user->firstname }} {{ $taskPerson->user->surname }}</li>
                @endif
            @endforeach
        </ul>
    </li>
    <li><strong>Opruimen:</strong>
        <ul>
            @foreach($taskPersons as $taskPerson)
                @if($taskPerson->task_per_activity_id === 4)
                    <li>{{ $taskPerson->user->firstname }} {{ $taskPerson->user->surname }}</li>
                @endif
            @endforeach
        </ul>
    </li>
</ul>

<h3>Belangrijk:</h3>
<ul>
    <li>Zorg ervoor dat je op tijd bent voor je taak.</li>
    <li>Neem contact op met de coördinator als je niet kunt komen.</li>
    <li>Wees behulpzaam en zorg ervoor dat alles netjes is achtergelaten.</li>
</ul>

<p>Veel plezier deze week!</p>

<p>Met vriendelijke groeten,</p>
<p>Trainers</p>
<p><strong>KVV Rauw</strong></p>
