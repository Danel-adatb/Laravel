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
@endsection
