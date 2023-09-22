<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Boardディレクトリ
Route::get('/board', \App\Http\Controllers\Board\IndexController::class)
    ->name('home');
Route::post('/board/create', \App\Http\Controllers\Board\CreateController::class)
    ->name('create'); // 新規スレッドを作成後、作成したページへ遷移
Route::get('/board/{threadId}', \App\Http\Controllers\Board\ThreadController::class)
    ->name('thread'); // スレッド個別ページを表示
Route::post('/board/{threadId}', \App\Http\Controllers\Board\WriteController::class)
    ->name('write'); // 既に存在しているスレッドに書き込み
Route::delete('/board/delete/w-{writeId}', \App\Http\Controllers\Board\DeleteController::class)
    ->name('write.delete');

// Board/Updateディレクトリ
Route::middleware('auth')->group(function () {
    Route::get('/board/update/w-{writeId}', \App\Http\Controllers\Board\Update\IndexController::class)
        ->name('update.index'); // 書き込みを編集
    Route::put('/board/update/w-{writeId}', \App\Http\Controllers\Board\Update\PutController::class)
        ->name('update.put'); // 書き込み更新処理
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
