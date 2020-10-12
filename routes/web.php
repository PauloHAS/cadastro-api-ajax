<?php

use App\Http\Controllers\Categorias;
use App\Http\Controllers\Produtos;
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
Route::get('/', function () {
    return view('index');
});

//produtos
Route::get('/produtos', [Produtos::class, 'indexView']);
Route::get('/categorias', [Categorias::class, 'indexView']);

