<!DOCTYPE html>
<html>
<head>
    <title>Trainer afwezig</title>
</head>
<body>
<p>Beste ouders,</p>
<p>Trainer {{ $trainer->firstname }} {{ $trainer->surname }} gaat niet aanwezig zijn op
    volgende {{ $eventDetails->is_match ? 'wedstrijd' : 'training' }}:</p>
<ul>
    <li>Event: {{ $eventDetails->is_match ? 'Wedstrijd' : 'Training' }}</li>
    <li>Date: {{ \Carbon\Carbon::parse($eventDetails->date)->format('Y-m-d') }}</li>
    <li>Time: {{ \Carbon\Carbon::parse($eventDetails->start)->format('H:i') }} -
        @if($eventDetails->is_match)
            {{ \Carbon\Carbon::parse($eventDetails->start)->addHour()->format('H:i') }}
        @else
            {{ \Carbon\Carbon::parse($eventDetails->end)->format('H:i') }}
        @endif
    </li>
</ul>
@if($eventDetails->is_match)
    <p>Deze wedstrijd zal dus zonder trainer doorgaan.</p>
@else
    <p>Deze training zal dus niet doorgaan.</p>
@endif
<p>Met vriendelijke groeten</p>
<p>Kvv Rauw</p>
</body>
</html>
