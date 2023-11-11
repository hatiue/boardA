## 内容

匿名掲示板をイメージしたものです。  
個人の学習用です。  
仕様（アプリ内にもメモという形で直接表示しています）
- スレッドに新規書き込みがあるとスレッドタイトルが浮上する
- 書き込みを編集・削除した場合、更新時間も表示
- 編集ボタンは会員名で書き込んだもののみ表示（ログイン時）
- 書き込み上限時、テキストボックスを非表示に（保存処理も不可）
- 画像が保存されていた場合表示（4枚まで）
- 「>>1」の形で書き込みがあればページ内ジャンプ

## 1.インストール

- Docker Desktopをインストール
- WSL2をインストール
- Microsoft StoreからUbuntuを入手(22.04)
- Docker Desktopの設定をUbuntuを利用するように変更
- Docker Desktopの設定でDocker Composeを有効にする
- Microsoft StoreからWindows Terminalを入手
- Windows TerminalからUbuntuを開き、sudo apt update && sudo apt upgrade -y

## 2.開発環境を再現する

- 下記引用のコマンドを入力
#### [Laravelドキュメント](https://readouble.com/laravel/10.x/ja/) パッケージ ＞ [Sailの章](https://readouble.com/laravel/10.x/ja/sail.html)
「既存アプリケーションでComposer依存関係のインストール」より一部を引用

>アプリケーションのリポジトリをローカルコンピュータにクローンした後、Sailを含むアプリケーションのComposer依存関係は一切インストールされていません。
>
>アプリケーションの依存関係をインストールするには、アプリケーションのディレクトリに移動し、次のコマンドを実行します。このコマンドは、PHPとComposerを含む小さなDockerコンテナを使用して、アプリケーションの依存関係をインストールします。
>
>docker run --rm \\
>    -u "$(id -u):$(id -g)" \\
>    -v "$(pwd):/var/www/html" \\
>    -w /var/www/html \\
>    laravelsail/php82-composer:latest \\
>    composer install --ignore-platform-reqs
#### ※コマンドのバックスラッシュを表示させるために、少し手を加えています。正確な表現はリンク先をご確認ください。

## 3.次の準備

「.env.example」に記載されている内容を、「.env」にリネームしてご使用ください。

## 4.起動する

下記のコマンドを順に実行
- cd board
- ./vendor/bin/sail up -d // アプリケーションコンテナをデーモン起動する
- ./vendor/bin/sail artisan migrate // テーブルを作成、初回起動時のみ

## 5.表示する

ローカルホストで表示します。  
http://localhost/board  
  
新規スレッドを作成してみてください。  
匿名での書き込みがデフォルトですが、会員登録してログインすると、会員名での書き込みが選択できるようになり、匿名でない書き込みの編集・削除が可能になります。  
  
## 6.終了する

- ./vendor/bin/sail down // アプリケーションコンテナを停止

## エイリアスの設定（オプション）

「./vendor/bin/sail」を「sail」に省略する設定
- vi ~/.profile
- alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'　// 左記を入力して保存
- source ~/.profile