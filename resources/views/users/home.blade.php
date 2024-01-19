<div class="flex justify-center items-center">
    <div class="container mt-12">
        <div>Your Rooms</div>
        @if(count($joined) > 0)
            <div class="flex flex-wrap mt-4">
                @foreach($joined as $room)
                    <a class="w-full lg:w-1/3 p-2 group" href="/room/{{ $room->id }}">
                        <div class="bg-slate-200  group-hover:bg-slate-300 aspect-video w-full p-4 rounded-lg relative flex justify-between flex-col">
                            <div class="text-gray-600 italic">Room No. {{ $room->room_number }}</div>
                            <div class="text-3xl text-gray-600 relative text-center font-black break-words">{{ $room->room_name }}</div>
                            <div class="w-full text-xl text-gray-600">{{ count($room->members) }} / <span class="font-bold">{{ $room->capacity }}</span></div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <p class="mt-4">No assigned room.</p>
        @endif
    </div>
</div>