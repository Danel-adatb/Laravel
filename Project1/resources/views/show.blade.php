@extends('layouts.app')

@section('title', $task->title)

@section('content')
    <nav class="mb-4">
        <a href=" {{ route('tasks.index') }} "
        class="btn">
            Back to task list!
        </a>
    </nav>

    <div>
        <p class="mb-4 text-slate-700"> {{ $task->description }} </p>
    </div>

    @if($task->long_description)
        <div>
            <p class="mb-4 text-slate-700"> {{ $task->long_description }} </p>
        </div>
    @endif

    <div>
        <p class="text-sm text-slate-500"> Created at: {{ $task->created_at->diffForHumans() }} </p>
    </div>

    <div>
        <p class="mb-4 text-sm text-slate-500"> Updated at: {{ $task->updated_at->diffForHumans() }} </p>
    </div>

    <div class="mb-4">
        @if ($task->completed)
            <span class="font-medium text-green-500">Completed</span>
        @else
            <span class="font-medium text-red-500">Not completed</span>
        @endif
    </div>

    <div class="flex gap-2">
        <a class="btn" href=" {{ route('tasks.edit', ['task' => $task]) }} ">Edit</a>

        <form method="POST" action=" {{ route('tasks.toggle', ['task' => $task]) }} ">
            @csrf
            @method('PUT')
            <button type="submit" class="btn">
                Mark as {{ $task->completed ? 'not completed' : 'completed' }}
            </button>
        </form>

        <form method="POST" action=" {{ route('tasks.delete', ['task' => $task]) }} ">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn">Delete Task</button>
        </form>
    </div>
@endsection
