@include('partials.header')
    @auth
            @if(auth()->user()->user_type === "admin")
                <div class="flex justify-center items-center">
                    <div class="container flex flex-col items-center justify-center mt-12 px-4">
                        <div class="w-full lg:w-1/2 text-start my-4"><a href="{{ '/room/' . $id }}" class="border px-4 py-2 rounded hover:bg-slate-100">Back</a></div>
                        <form action="{{ route('add.member', ['id' => $id ]) }}" method="post" class="flex flex-col justify-center gap-2 items-center w-full lg:w-1/2  border py-12 px-6">
                            @csrf
                            <h1 class="text-xl mb-6">Add Member</h1>
                            <input type="hidden" name="id" id="id" value="{{ $id }}">
                            <select id="employee_id" name="employee_id" class="px-4 py-2 border w-full rounded">
                                <option value="" >Select</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" >{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @if(session('message'))
                                <div class="text-red-600 text-sm my-2">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <button class="px-4 py-2 border rounded w-full bg-blue-500 hover:bg-blue-400 text-white" type="submit">Add Member</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="text-center mt-12"><div class="mb-2">404 Not Found</div><a href="/" class="border px-4 py-2 rounded hover:bg-slate-100">Home</a></div>
            @endif
    @endauth
@include('partials.footer')
