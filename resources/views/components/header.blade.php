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
        @auth
        ユーザーID：{{ auth()->id() }}でログイン中　そのうち名前に変える
            <form action="{{ route('logout') }}" method="post">
                @csrf    
                <button>ログアウト</button>
            </form>
        @endauth
        @guest
            <a href="{{ route('login') }}">ログイン</a>
            <a href="{{ route('register') }}">会員登録</a>
        @endguest
    </div>
</head>
