@extends('layouts.app')

@section('title', $task->title)

@section('content')
    <div>
        <p> {{ $task->description }} </p>
    </div>

    @if($task->long_description)
        <div>
            <p> {{ $task->long_description }} </p>
        </div>
    @endif

    <div>
        <p> {{ $task->created_at }} </p>
    </div>

    <div>
        <p> {{ $task->updated_at }} </p>
    </div>

    <div>
        @if ($task->completed)
            Completed
        @else
            Not Completed
        @endif
    </div>

    <div>
        <a href=" {{ route('tasks.edit', ['task' => $task]) }} ">Edit</a>
    </div>

    <div>
        <form method="POST" action=" {{ route('tasks.toggle', ['task' => $task]) }} ">
            @csrf
            @method('PUT')
            <button type="submit">
                Mark as {{ $task->completed ? 'not completed' : 'completed' }}
            </button>
        </form>
    </div>

    <div>
        <form method="POST" action=" {{ route('tasks.delete', ['task' => $task]) }} ">
            @csrf
            @method('DELETE')
            <button type="submit">Delete Task</button>
        </form>
    </div>
@endsection
