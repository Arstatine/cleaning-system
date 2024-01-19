<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cleaning System</title>
        
        <style>
            @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap");

            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
                font-family: "Montserrat", sans-serif;
            }
        </style>
        <script src="https://cdn.tailwindcss.com"></script>
        {{-- @vite('resources/css/app.css') --}}
    </head>
    <body class="antialiased">
        <div class="flex justify-between items-center px-8 py-6 bg-slate-900">
            <a href="/" class="font-bold text-white text-2xl hidden sm:block">Cleaning System</a>
            <a href="/" class="font-bold text-white text-2xl block sm:hidden">CS</a>
            
        @auth
        <div class="flex gap-2">
            <div class="capitalize text-white px-4 py-2 rounded">{{ auth()->user()->name }}</div>
            <form action="/logout" method="post">
                @csrf
                <button type="submit" class="hover:bg-red-600 bg-red-700 text-white px-4 py-2 rounded cursor-pointer">Logout</button>
            </form>
        </div>
        @else
            <div>
                <a href='/' class="px-4 py-2 text-white hover:opacity-75">Register</a>
                <a href='/login' class="px-4 py-2 text-white hover:bg-slate-800 border border-white hover:text-white rounded">Login</a>
            </div>
        @endauth
        </div>