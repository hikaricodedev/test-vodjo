<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});

Route::get('/{pathMatch}' , functioN(){
    return view('main');
})->where('pathMatch',".*");
