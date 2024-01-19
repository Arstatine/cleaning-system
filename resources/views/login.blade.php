@include('partials.header')
        <div class="flex justify-center items-center">
            <div class="container flex justify-center mt-12">
                <div class="flex flex-col justify-center gap-2 items-center w-full lg:w-1/2  border py-12 px-12">

                <form action="{{ route('login.form') }}" method="post" class="w-full">
                        @csrf
                    <h1 class="text-xl mb-6 text-center">Login</h1>
                    <input type="text" id="email" name="email" class="px-4 py-2 border w-full rounded mt-2" placeholder="Email" required/>
                    <input type="password" id="password" name="password" class="px-4 py-2 border w-full rounded mt-2" placeholder="Password" required/>
                    @if(session('message'))
                    <div class="text-red-600 text-sm my-2">
                        {{ session('message') }}
                    </div>
                    @endif
                    <button class="text-white px-4 py-2 border rounded w-full bg-blue-500 hover:bg-blue-400 mt-2" type="submit">Login</button>
                </form>
                
                <p class="mt-2">- or -</p>
                @if(session('err_google'))
                    <div class="text-red-600 text-sm mt-2">
                        {{ session('err_google') }}
                    </div>
                    @endif
                <a href="{{ route('google.login') }}" class="text-white text-center px-4 py-2 border rounded w-full bg-blue-500 hover:bg-blue-400 mt-2">Sign in with Google</a>
                </div>
            </div>
        </div>
@include('partials.footer')
