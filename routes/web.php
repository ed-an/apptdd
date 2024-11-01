<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectsTasksController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectsController;
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


Route::group(['middleware' => 'auth'], function () {

//    Route::get('/projects', [ProjectsController::class,'index']);
//    Route::get('/projects/create', [ProjectsController::class,'create']);
//    Route::get('/projects/{project}', [ProjectsController::class,'show']);
//    Route::get('/projects/{project}/edit', [ProjectsController::class,'edit']);
//    Route::patch('/projects/{project}', [ProjectsController::class,'update']);
//    Route::post('/projects', [ProjectsController::class,'store']);
//    Route::delete('/projects/{project}', [ProjectsController::class,'destroy']);

    Route::resource('projects', ProjectsController::class);

    Route::post('/projects/{project}/tasks', [ProjectsTasksController::class,'store']);
    Route::patch('/projects/{project}/tasks/{task}', [ProjectsTasksController::class,'update']);


    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Auth::routes();


