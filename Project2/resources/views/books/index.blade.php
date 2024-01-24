@extends('layouts.app')

@section('content')
    <H1 class="mb-10 text-2xl">Books</H1>

    <!-- space-x-2: this is only for HORIZONTAL spacing, items-center that aligns VERTICALLY -->
    <form method="GET" action="{{ route('books.index')}}" class="mb-4 flex items-center space-x-2">
        <input type="text" name="title" placeholder="Search by Title" value="{{ request('title') }}" class="input h-10">
        <!-- This solves the problem that when I search and click on the latest, highest rated tabs, etc after search it won't disappear -->
        <input type="hidden" name="filter" value="{{request('filter')}}">
        <button type="submit" class="btn h-10">Search</button>
        <a href="{{ route('books.index') }}" class="btn h-10">Clear</a>
    </form>

    <div class="filter-container mb-4 flex">
        @php
            $filters = [
                '' => 'Latest',
                'popular_last_month' => 'Popular Last Month',
                'popular_last_6_months' => 'Popular Last 6 Months',
                'highest_rated_last_month' => 'Highest Rated Last Month',
                'highest_rated_last_6_months' => 'Highest Rated Last 6 Months',
            ];
        @endphp

        <!-- Solution for when $key is '' -->
        <!-- request()->query(): this has all the query parameters of the request -->
        <!-- ...   This is a spread operator -> unpacks the query array and adds the elements for the whole array [...req.... => $key]-->
        @foreach ($filters as $key => $label)
            <a href="{{route('books.index', [...request()->query(), 'filter' => $key])}}"
                class="{{request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item'}}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <ul>
        @forelse ($books as $book)
            <li class="mb-4">
                <div class="book-item">
                    <div class="flex flex-wrap items-center justify-between">
                        <div class="w-full flex-grow sm:w-auto">
                            <a href="{{ route('books.show', $book) }}" class="book-title">{{$book->title}}</a>
                            <span class="book-author">By {{$book->author}}</span>
                        </div>
                        <div>
                            <div class="book-rating">
                                <x-star-rating :rating="$book->reviews_avg_rating" />
                            </div>
                            <div class="book-review-count">
                                <!-- Str:plural('one single review', 'multiple reviews')------ [plural form, it's just some nice looking] -->
                                out of {{$book->reviews_count}} {{Str::plural('review', $book->reviews_count)}}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse
    </ul>
@endsection
