@extends('layouts.app')

@section('title', 'List of tasks')

@section('content')
    <nav class="mb-4">
        <a href=" {{ route('tasks.create') }} "
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded text-sm px-2 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Add Task
        </a>
    </nav>

    @forelse ($tasks as $t)
        <div>
            <a href="{{ route('tasks.show', ['task' => $t->id]) }}"
            @class(['font-bold', 'line-through' => $t->completed])>
                {{ $t->title }}
            </a>
        </div>
    @empty
        <div>There are no task!</div>
    @endforelse

    @if ($tasks->count())
        <nav class="mt-4">
            {{ $tasks->links() }}
        </nav>
    @endif
@endsection

