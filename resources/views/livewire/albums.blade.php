<div>
    <h1 class="m-5 font-bold">Albums</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 2xl:grid-cols-3 gap-8 mt-8">
        @forelse ($albums as $album)
            <div wire:key="album-{{$album->id}}" class="flex flex-col bg-white border border-gray-300 shadow-md rounded-lg overflow-hidden">
                <a href="{{ route('photos', ['albumId' => $album->id]) }}"><img class="w-full h-80 object-cover"
                                                     src="{{ $album->cover_photo_path ?? asset('storage/covers/no-cover.jpg') }}"
                                                     title="{{$album->name}}"></a>
                <div class="p-4">
                    <h3 class="text-lg font-medium">{{ $album->name }}</h3>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center p-4 text-gray-500">
                <div class="font-bold italic text-sky-800">No albums found</div>
            </div>
        @endforelse
    </div>
    <x-slot name="footerName">
        Kobe Schoeters
    </x-slot>

    {{-- Detail section --}}
</div>
