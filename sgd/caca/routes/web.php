<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/pipi', function (Request $request) {

    return [
        "slug" =>$slug,
        "id" =>$id,
        'name'  s
    ];
});
 