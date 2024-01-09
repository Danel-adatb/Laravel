<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function() {
    return redirect()->route('tasks.index');
});

//If you use Query Builder such as the example below, you have to 'execute' the query with the get() method!
Route::get('/tasks', function() {
    return view('index', [
        'tasks' => \App\Models\Task::latest()/*->where('completed', true)*/->get()
    ]);
})->name('tasks.index');

Route::get('/tasks/{id}', function($id) {
    //Laravel Query
    /*$task = collect($tasks)->firstWhere('id', $id);

    if(!$task) {
        //404 Response when the page is not found or cannot be found!
        abort(Response::HTTP_NOT_FOUND);
    }*/

    return view('show', ['task' => \App\Models\Task::findOrFail($id)]);
})->name('tasks.show');
