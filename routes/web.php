<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DeploymentController;

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
    // return request()->server();
    return view('welcome');
});

Auth::routes([ 'register' => false ]);

Route::middleware('auth')->group(function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::resource('servers', ServerController::class);

    Route::get('projects/{project}/deployments', DeploymentController::class)->name('projects.deployments');
    Route::resource('projects', ProjectController::class)->except(['update', 'store']);
});
