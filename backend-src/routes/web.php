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

// TODO Check in here if there are the payload for provision the user

// TODO change the welcome page to some Pyara's introduction
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', '\App\Http\Controllers\User\IndexController@index')
->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/task/{id}', '\App\Http\Controllers\User\IndexController@viewTask')
->middleware(['auth', 'verified']);

Route::post('/task/{id}', '\App\Http\Controllers\User\IndexController@getTask')
->middleware(['auth', 'verified']);



require __DIR__.'/auth.php';

Route::resource('admin/project', 'App\Http\Controllers\Admin\ProjectController');

Route::resource('admin/change-request', 'App\Http\Controllers\Admin\ChangeRequestController');

Route::resource('participant/task', 'App\Http\Controllers\Participant\TaskController');
Route::resource('participant/solution', 'App\Http\Controllers\Participant\SolutionController');