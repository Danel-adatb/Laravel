@extends('layouts.app')

@section('title', 'List of tasks')

@section('content')
    @forelse ($tasks as $t)
        <div>
            <a href="{{ route('tasks.show', ['task' => $t->id]) }}">{{ $t->title }}</a>
        </div>
    @empty
        <div>There are no task!</div>
    @endforelse

    @if ($tasks->count())
        <br>
        <nav>
            {{ $tasks->links() }}
        </nav>
    @endif
@endsection

