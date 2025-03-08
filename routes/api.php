<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

# test
//Route::any('/dbcon',function (){ return response()->json([ DB::SELECT("SELECT * FROM users")  ]); }) ;

Route::post('/shrink',[App\Http\Controllers\ImageController::class,'shrink_image']);

//Route::any('/shrink', 'App\Http\Controllers\ImageController@shrink_image');
