<div>
    <h1 class="m-5 font-bold">Mails Beheren</h1>

    {{-- Filters --}}
    <x-tmk.section class="mb-4 flex gap-2">
        <div class="flex-1">
            <x-input id="search" type="text" placeholder="Filter op onderwerp"
                     wire:model.live.debounce.500ms="search"
                     class="w-full shadow-md placeholder-gray-300"/>
        </div>
    </x-tmk.section>

    {{-- Table with mailtemplates --}}
    <x-tmk.section>
        <table class="text-center w-full border border-gray-300">
            <thead>
            <tr class="bg-gray-100 text-gray-700 [&>th]:p-2">
                <th>Onderwerp</th>
                <th>Verstuurder</th>
                <th>Ontvanger</th>
                <th>Verzenden</th>
            </tr>
            </thead>
            <tbody>
            @forelse($mails as $mail)
                <tr class="border-t border-gray-300">
                    <td>{{ $mail->subject}}</td>
                    <td>{{ $mail->from }}</td>
                    <td>{{ $mail->to }}</td>
                    <td>
                        <div class="border border-gray-300 rounded-md overflow-hidden m-2 grid grid-cols-1 h-10">
                            <button
                                class="text-gray-400 hover:text-green-100 hover:bg-green-500 transition"
                                wire:click="sendMail({{ $mail->id }})"
                                wire:confirm="Are you sure you want to send this mail?">
                                <x-phosphor-envelope-duotone class="inline-block w-5 h-5"/>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="border-t border-gray-300 p-4 text-center text-gray-500">
                        <div class="font-bold italic text-sky-800">No records found</div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </x-tmk.section>

    <x-slot name="footerName">Lucas Vanden Heede</x-slot>
</div>
