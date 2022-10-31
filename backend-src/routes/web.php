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

Route::get('/dashboard', '\App\Http\Controllers\Participant\IndexController@index')
->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/task/{id}', '\App\Http\Controllers\Participant\IndexController@viewTask')
->middleware(['auth', 'verified'])->name('show-task');

Route::post('/task/{id}', '\App\Http\Controllers\Participant\IndexController@viewTask')
->middleware(['auth', 'verified']);

Route::get('/task/{id}/solution/create', '\App\Http\Controllers\Participant\IndexController@showFormCreateSolution')
->middleware(['auth', 'verified']);

Route::post('/solution', '\App\Http\Controllers\Participant\IndexController@createSolution')
->middleware(['auth', 'verified']);

Route::patch('/solution/{solutionId}', '\App\Http\Controllers\Participant\IndexController@updateSolution')
->middleware(['auth', 'verified']);

Route::get('/solution/{solutionId}', '\App\Http\Controllers\Participant\IndexController@viewSolution')
->middleware(['auth', 'verified'])->name('show-solution');

Route::get('/solution/{solutionId}/edit', '\App\Http\Controllers\Participant\IndexController@showFormEditSolutionDescription')
->middleware(['auth', 'verified'])->name('edit-solution-description');

Route::get('/solution/{solutionId}/item/{itemId}/edit', '\App\Http\Controllers\Participant\IndexController@showFormEditItemSolution')
->middleware(['auth', 'verified']);

Route::post('/solution/{solutionId}/item/{itemId}/edit', '\App\Http\Controllers\Participant\IndexController@updateItemSolution')
->middleware(['auth', 'verified']);

Route::delete('/solution/{solutionId}/item/{itemId}', '\App\Http\Controllers\Participant\IndexController@removeItemSolution')
->middleware(['auth', 'verified']);


Route::get('/solution/{solutionId}/item/create', '\App\Http\Controllers\Participant\IndexController@showFormCreateItemSolution')
->middleware(['auth', 'verified'])->name('show-form-create-item-solution');

Route::post('/solution/{solutionId}/item/create', '\App\Http\Controllers\Participant\IndexController@storeItemSolution')
->middleware(['auth', 'verified'])->name('create-item-solution');

Route::get('/solution/{solutionId}/item/{itemId}/link/create', '\App\Http\Controllers\Participant\IndexController@showFormCreateLinkItemSolution')
->middleware(['auth', 'verified']);

Route::post('/solution/{solutionId}/item/{itemId}/link', '\App\Http\Controllers\Participant\IndexController@storeLinkItemSolution')
->middleware(['auth', 'verified']);

Route::delete('/solution/{solutionId}/item/{itemId}/link/{linkId}', '\App\Http\Controllers\Participant\IndexController@removeLinkItemSolution')
->middleware(['auth', 'verified']);

Route::get('/solution/{solutionId}/item/{itemId}/link/{linkId}', '\App\Http\Controllers\Participant\IndexController@showFormEditLinkItemSolution')
->middleware(['auth', 'verified']);

Route::post('/solution/{solutionId}/item/{itemId}/link/{linkId}', '\App\Http\Controllers\Participant\IndexController@updateLinkItemSolution')
->middleware(['auth', 'verified']);


require __DIR__.'/auth.php';

Route::resource('admin/project', 'App\Http\Controllers\Admin\ProjectController');

Route::resource('admin/change-request', 'App\Http\Controllers\Admin\ChangeRequestController');

Route::resource('participant/task', 'App\Http\Controllers\Participant\TaskController');
Route::resource('participant/solution', 'App\Http\Controllers\Participant\SolutionController');
Route::resource('participant/item-solution', 'App\Http\Controllers\Participant\ItemSolutionController');
Route::resource('participant/item-solution-link', 'App\Http\Controllers\Participant\ItemSolutionLinkController');
Route::resource('review/evaluation', 'App\Http\Controllers\Review\EvaluationController');


// authenticate
Route::get('survey/{token}', 'App\Http\Controllers\SurveyController@provisionUser');

// Only for debug purpose
Route::get('test/{token}', 'App\Http\Controllers\SurveyController@test');
