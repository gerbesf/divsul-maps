<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\IndexController::class,'welcome'])->name('votemap')->middleware('setup');
Route::get('/votemap', [\App\Http\Controllers\VotemapController::class,'votemap'])->name('votemap_page');
Route::get('/history', [\App\Http\Controllers\ServerHistoryController::class,'history'])->name('history')->middleware('setup');

#Route::get('/online', [\App\Http\Controllers\PlayersOnline::class,'index'])->name('players');
Route::get('/maps', [\App\Http\Controllers\MapsController::class,'management'])->name('maps');
Route::get('/admins', [\App\Http\Controllers\AdminsController::class,'management'])->name('admins');
Route::get('/setup', [\App\Http\Controllers\SetupController::class,'setup'])->name('setup');
Route::post('/setup/update', [\App\Http\Controllers\SetupController::class,'update'])->name('setup_update');

Route::get('/offline',function (){
    echo 'Server not configured';
})->name('offline');

Route::get('/profile', function () {
    return view('dashboard');
})->middleware(['auth'])->name('profile');

Route::get('/profile/password', function () {
    return view('change_password');
})->middleware(['auth'])->name('change_password');

Route::post('/profile/password',[App\Http\Controllers\PasswordController::class,'doChangePassword'])->name('doChangePassword');

require __DIR__.'/auth.php';
