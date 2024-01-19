@include('partials.header')
    @auth
        @if(auth()->user()->user_type === "admin")
            <div class="flex justify-center items-center">
                {{-- MAIN CONTENT --}}
                <div class="container flex flex-col justify-center mt-12">
                    <div class="flex flex-col items-center w-full px-4">
                            <div class="w-full lg:w-1/2 text-start my-4 flex justify-between">
                                <a href="/" class="border px-4 py-2 rounded hover:bg-slate-100">Back</a>
                                <a href="/room/{{ $id }}/add" class="border px-4 py-2 rounded bg-green-500 hover:bg-green-400 text-white">Add Member</a>
                            </div>

                            <div class="text-4xl font-bold">
                                {{ $data->room_name }}
                            </div>
                            <div class="text-lg italic">
                                <span class="font-bold">Room No.</span> {{ $data->room_number }}
                            </div>
                            
                            <div class="w-full lg:w-1/2 pb-6">
                                @foreach($images as $image)
                                    @if($image)
                                        <div class="flex flex-wrap mt-6 mb-2">
                                            @foreach($image as $img)
                                                <a href="{{ asset('images/' . $img->path) }}" target="_blank" class="aspect-square w-1/3 lg:w-1/4 border rounded group cursor-pointer">
                                                    <img src="{{ asset('images/' . $img->path) }}" alt="Image" class="aspect-square object-cover">
                                                </a>
                                                
                                                @php
                                                    $approve = $img->approve;
                                                    $created = $img->created_at;
                                                    $user_name = $img->user->name;
                                                    $email = $img->user->email;
                                                    $group_id = $img->group_id;
                                                @endphp
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="italic text-sm font-bold">{{ $user_name }}</div>
                                    <div class="italic text-sm">{{ $created }}</div>
                                    
                                    @if(!$approve)
                                        <div class="w-full lg:w-1/2 mt-2 flex gap-2">
                                            <form action="{{ route('approve', ['id' => $id]) }}" method="post">
                                                @csrf
                                                <input type="hidden" value="{{ $group_id }}" id="group_id" name="group_id">
                                                <input type="hidden" value="{{ $email }}" id="email" name="email">
                                                <button class="text-start italic text-sm text-green-400 font-bold px-3 hover:bg-slate-100 py-1 border rounded" type="submit">Accept</button>
                                            </form>
                                            <form action="{{ route('reject', ['id' => $id]) }}" method="post">
                                                @csrf
                                                <input type="hidden" value="{{ $group_id }}" id="group_id" name="group_id">
                                                <input type="hidden" value="{{ $email }}" id="email" name="email">
                                                <button class="text-start italic text-sm text-red-400 font-bold px-3 hover:bg-slate-100 py-1 border rounded" type="submit">Reject</button>
                                            </form>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                    </div>
                </div>
            </div>
        @else
            @if($joined)
                <div class="flex justify-center items-center">
                    <div class="container flex flex-col justify-center mt-12">
                        <div class="flex flex-col items-center w-full px-4">
                            <div class="w-full lg:w-1/2 text-start my-4 flex justify-between">
                                <a href="/" class="border px-4 py-2 rounded hover:bg-slate-100">Back</a>
                            </div>

                            <div class="text-4xl font-bold">
                                {{ $data->room_name }}
                            </div>
                            <div class="text-lg italic">
                                <span class="font-bold">Room No.</span> {{ $data->room_number }}
                            </div>
                            <div class="w-full lg:w-1/2 mb-[100px]">
                                @foreach($images as $image)
                                    @if($image)
                                        <div class="flex flex-wrap mt-6 mb-2">
                                            @foreach($image as $img)
                                                <a href="{{ asset('images/' . $img->path) }}" target="_blank" class="aspect-square w-1/3 lg:w-1/4 border rounded group cursor-pointer">
                                                    <img src="{{ asset('images/' . $img->path) }}" alt="Image" class="aspect-square object-cover">
                                                </a>
                                                
                                                @php
                                                    $approve = $img->approve;
                                                    $created = $img->created_at;
                                                @endphp
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="italic text-sm font-bold">{{ $user->name }}</div>
                                    <div class="italic text-sm">{{ $created }}</div>
                                    
                                    @if(!$approve)
                                    <div class="w-full lg:w-1/2 mt-2">
                                        <p class="text-start italic text-sm text-orange-400 font-bold">Pending</p>
                                    </div>
                                @endif
                                @endforeach
                            </div>
                            <form action="{{ route('upload', ['id' => $id]) }}" method="post" enctype="multipart/form-data" class="px-4 fixed bottom-0 w-full flex justify-center items-center gap-2 py-4 bg-[rgba(0,0,0,.5)]">
                                @csrf
                                <input type="file" name="images[]" multiple class="cursor-pointer bg-slate-200 p-2 rounded" accept="image/png, image/gif, image/jpeg">
                                <input type="hidden" name="room_id" value="{{ $id }}">
                                <button type="submit" class="px-4 py-3 bg-blue-500 rounded text-white">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center mt-12"><div class="mb-2">404 Not Found</div><a href="/" class="border px-4 py-2 rounded hover:bg-slate-100">Home</a></div>
            @endif
        @endif
    @endauth
@include('partials.footer')
