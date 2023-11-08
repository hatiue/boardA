<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            color: gray;
            background-color: black;
        }
        a {
            text-decoration: none;
        }
    </style>
    <!-- scriptタグはtypeを追記すると動く -->
    <!-- <script type="module" src="{{ 'resources/js/app.js' }}"></script> -->
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>けいじばん</title>
</head>
<body class="flex flex-col min-h-screen">
    <div class="w-full bg-slate-700 sticky top-0 p-2">
        <div class="container mx-auto text-white">
            <button class="bg-green-500 rounded p-1"><a href="{{ route('try') }}">cssテストページへ</a></button>
            @auth
            <span>今はユーザーID「{{ auth()->id() }}」、ユーザー名「{{ auth()->user()->name }}」でログイン中</span>
                <form id="logout" action="{{ route('logout') }}" method="post" class="inline-flex">
                    @csrf    
                    <x-button-logout></x-button-logout>
                </form>
            @endauth
            @guest
            <span>ログインしていません。</span>
                <x-button-login></x-button-login>
                <x-button-register></x-button-register>
            @endguest
        </div>
    </div>