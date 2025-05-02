<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

\Illuminate\Support\Facades\Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {
   Route::post('/todos', [TodoController::class,'store'])->name('todos.store');
   Route::get('/todos/create',[TodoController::class,'create'])->name('todos.create');
   Route::get('/todos/{todo}/edit',[TodoController::class,'edit'])->name('todos.edit');
   Route::match(['get','put','patch'],'/todos/{todo}', [TodoController::class,'update'])->name('todos.update');
});
