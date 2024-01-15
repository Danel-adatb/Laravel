@extends('layouts.app')

@section('title', 'List of tasks')

@section('content')
    <nav class="mb-4">
        <a href=" {{ route('tasks.create') }} "
        class="btn">
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

