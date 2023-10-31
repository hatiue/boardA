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
<body>
    <div class="w-full bg-slate-700 sticky top-0">
        <div class="container mx-auto text-white">
            <p>header: viteを使用</p>
            <button class="bg-green-500 rounded p-1"><a href="{{ route('try') }}">cssテストページへ</a></button>
            今は
            @auth
            ユーザーID「{{ auth()->id() }}」、ユーザー名「{{ auth()->user()->name }}」でログイン中 Auth::user()->nameでも表示
                <form id="logout" action="{{ route('logout') }}" method="post">
                    @csrf    
                    <x-button-logout></x-button-logout>
                </form>
            @endauth
            @guest
            ログインしていません。
                <x-button-login></x-button-login>
                <x-button-register></x-button-register>
            @endguest
        </div>
    </div>