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
    <title>けいじばん</title>
    <p>header: welecome.blade.phpより</p>
    <div>
        今は
        @auth
        ユーザーID「{{ auth()->id() }}」、ユーザー名「{{ auth()->user()->name }}」でログイン中 Auth::user()->nameでも表示
            <form action="{{ route('logout') }}" method="post">
                @csrf    
                <button>ログアウト</button>
            </form>
        @endauth
        @guest
        ログインしていません。
            <a href="{{ route('login') }}">ログイン</a>
            <a href="{{ route('register') }}">会員登録</a>
        @endguest
    </div>
</head>
