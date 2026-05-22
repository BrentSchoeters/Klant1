<div>
    <h1 class="m-5 font-bold">Afwezigheid Wedstrijdhulp</h1>
    <x-tmk.section>
        <table class="text-center w-full border border-gray-300">
            <thead>
            <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                <th>Datum</th>
                <th>Tegenstander</th>
                <th>Taak</th>
                <th>Afmelden</th>
            </tr>
            </thead>
            <tbody>
            @forelse($wedstrijden as $match)
                @php
                    $tasksForUser = $match->task_per_activities->filter(function($taskPerActivity) use ($userId) {
                        return $taskPerActivity->person_per_tasks->contains('user_id', $userId);
                    });
                    $firstRow = true;
                    $rowspan = $tasksForUser->count();
                @endphp

                @foreach($tasksForUser as $taskPerActivity)
                    <tr class="border-t border-gray-300">
                        @if($firstRow)
                            <td rowspan="{{ $rowspan }}">{{ $match->date }}</td>
                            <td rowspan="{{ $rowspan }}">{{ $match->opponent }}</td>
                            @php $firstRow = false; @endphp
                        @endif
                        <td>{{ $taskPerActivity->task->task }}</td>
                        <td>
                            <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid h-10">
                                <button class="text-gray-400 hover:text-sky-100 hover:bg-sky-500 transition border-r border-gray-300"
                                        wire:click="delete({{ $taskPerActivity->person_per_tasks }})">
                                    <x-phosphor-pencil-line-duotone class="inline-block w-5 h-5"/>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="4" class="border-t border-gray-300 p-4 text-center text-gray-500">
                        <div class="font-bold italic text-sky-800">Geen taken gevonden</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </x-tmk.section>
    <x-slot name="footerName">
        Kobe Schoeters
    </x-slot>
</div>
