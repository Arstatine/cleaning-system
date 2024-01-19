@include('partials.header')

        @auth
            @if(auth()->user()->user_type === "admin")
                @include("admin.home")
            @else
                @include("users.home")
            @endif
        @else
            <div class="flex justify-center items-center">
                <div class="container flex justify-center mt-12">
                    <form action="{{ route('submit.form') }}" method="post" class="flex flex-col justify-center gap-2 items-center w-full lg:w-1/2  border py-12 px-6">
                        @csrf
                        <h1 class="text-xl mb-6">Create User Data</h1>
                        <input type="text" id="name" name="name" class="px-4 py-2 border w-full rounded" placeholder="Name" required/>
                        <input type="text" id="employee_id" name="employee_id" class="px-4 py-2 border w-full rounded" placeholder="Employee ID" required/>
                        <input type="date" id="birthday" name="birthday" class="px-4 py-2 border w-full rounded" placeholder="Birthday" required/>
                        <input type="email" id="email" name="email" class="px-4 py-2 border w-full rounded" placeholder="Email" required/>
                        <input type="number" id="cp" name="cp" class="px-4 py-2 border w-full rounded" placeholder="Phone" required/>
                        @if(session('message'))
                            <div class="text-red-600 text-sm my-2">
                                {{ session('message') }}
                            </div>
                        @endif
                        <button class="text-white px-4 py-2 border rounded w-full bg-blue-500 hover:bg-blue-400" type="submit">Create</button>
                    </form>
                </div>
            </div>
        @endauth
@include('partials.footer')
