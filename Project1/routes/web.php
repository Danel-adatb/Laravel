<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
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
/*->where('completed', true)*/
Route::get('/tasks', function() {
    return view('index', [
        'tasks' => Task::latest()->paginate(10)
    ]);
})->name('tasks.index');

Route::view('/tasks/create', 'create')->name('tasks.create');

//Route Model binding: {id} -> {task} ... Task $task

//This way Model fetching is done automatically
//Define the {task} not take it as an ID in Task.php
//Used if we want to fetch one single 'Task'
Route::get('/tasks/{task}/edit', function(Task $task) {
    return view('edit', [
        'task' => $task
    ]);
})->name('tasks.edit');

Route::get('/tasks/{task}', function(Task $task) {
    //Laravel Query
    /*$task = collect($tasks)->firstWhere('id', $id);

    if(!$task) {
        //404 Response when the page is not found or cannot be found!
        abort(Response::HTTP_NOT_FOUND);
    }*/

    return view('show', ['task' => $task]);
})->name('tasks.show');

Route::post('/tasks', function(TaskRequest $request) {
    //Validation part is in the app/Http/Request/TaskRequest.php file, made as a rule!
    // php artisan make:request TaskRequest

    /*$data = $request->validated();

    $task = new Task;

    $task->title = $data['title'];
    $task->description = $data['description'];
    $task->long_description = $data['long_description'];

    $task->save();*/

    //Task.php to make it work!!
    $task = Task::create($request->validated());

    return redirect()->route('tasks.show', ['task' => $task->id])
        ->with('success', 'Task created successfully!');
})->name('tasks.store');

Route::put('/tasks/{task}', function(TaskRequest $request, Task $task) {
    //Validation part is in the app/Http/Request/TaskRequest.php file, made as a rule!
    // php artisan make:request TaskRequest

    /*$data = $request->validated();

    $task->title = $data['title'];
    $task->description = $data['description'];
    $task->long_description = $data['long_description'];

    $task->save();*/

    //Task.php to make it work!!
    $task->update($request->validated());

    return redirect()->route('tasks.show', ['task' => $task->id])
        ->with('success', 'Task updated successfully!');
})->name('tasks.update');

Route::delete('/tasks/{task}', function(Task $task) {
    $task->delete();

    return redirect()->route('tasks.index')->with('success', 'Task deleted succesfully!');
})->name('tasks.delete');

//Method for toggle in Task.php
Route::put('tasks/{task}/toggle-complete', function(Task $task) {
    $task->toggleComplete();

    return redirect()->back()->with('success', 'Task Updated successfully!');
})->name('tasks.toggle');
