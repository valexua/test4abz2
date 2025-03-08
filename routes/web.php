<?php

use Illuminate\Support\Facades\Route;

Route::view('/','home');
Route::view('/about','welcome');


Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users');
Route::get('/users/load-more', [App\Http\Controllers\UserController::class, 'loadMoreIndex']);
Route::get('/users/load-more-api', [App\Http\Controllers\UserController::class, 'getMoreApi']);


Route::get('register',[App\Http\Controllers\RegisterController::class, 'registerView'])->name('register');
//Route::view('register','users.register')->name('register');
//Route::get('register', function (){ return view('users.register'); })->name('register');

Route::post('register', [App\Http\Controllers\RegisterController::class, 'register']);
Route::post('api-register', [App\Http\Controllers\RegisterController::class, 'api_register']);

//require __DIR__.'/auth.php';
