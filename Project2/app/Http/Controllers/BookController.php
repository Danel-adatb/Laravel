<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter', '');

        //If the $title is null it won't run the function, othervise it will (when() method's logic)
        //You see the when() methods working logic when you search for a Title!
        $books = Book::when(
            $title,
            fn($query, $title) => $query->title($title)
        );

        /**
         * HERE IS THE LOGIC OF THE FILTERING
         */
        //match() is like a switch() just it lets you return a value!
        //It is NOT a function it is a STATEMENT
        $books = match($filter) {
            'popular_last_month' => $books->popularLastMonth(),
            'popular_last_6_months' => $books->popularLast6Months(),
            'highest_rated_last_month' => $books->highestRatingLastMonth(),
            'highest_rated_last_6_months' => $books->highestRatingLast6Months(),
            default => $books->latest()->withAvgRated()->withReviewsCount()
        };

        //$books = $books->get();
        /**
         * We store the books inside the cache for an hour (3600 sec), so we prevent all the time loading when the page is loaded
         * It checks if the cache contains the books, if yes we dont have to load it, if we dont, then we laod it
         *
         * User experience problem, filter wouldn't work properly
         * (solution for that is the cacheKey logic, because the key also contains the title and filter)
         * Also we mustn't cache data that is private or not public
         * We can display some private data to different users in this way
         */

         //If a lot of people are looking for (there is a popular search, popular new book, etc.), we will have just the cached result to load
        $cacheKey = 'books:' . $filter . ':' . $title;
        $books = cache()->remember($cacheKey, 3600, fn() => $books->get());

        //Call the view names the same as the route names (Commonly used Laravel convention that you should name the view the same as the route)
        return view('books.index', /*OR*/['books' => $books]);
        /*
         * OR compact('books')
         * this will do that finds a variable with the 'books' name,
         * and turn it into an array with the key books, and the variable with the same name
         */
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * The lazy loading:
     * When we access the relationship name by the property name, not by a method (for example: foreach($book->reviews as $review))
     * Laravel will lazy load all the related relations of a particual book
     * In that moment it makes the query when it encounters (that property being accessed) - Amikor odaér a kód és lefuttatja parasztosan
     * It also happens in blades
     *
     * As long as the lazy loadings don't eat up your resources of the dabase or the server it is totally fine to use them
     */
    public function show(int $id)
    {
        //We load one single book model, with a specific relationship (reviews), but
        //in our case it is already loaded in the arguments
        //Book::with('reviews')->findOrFail(); P#1 Example

        //load() method lets you load certain relations
        //With this solution there would be no separate lazy loading in Blade, but instantly loads here
        //This solution would work perfectly if we say we have 100 or even more books, so the good performance is a must
        //Also we order by the reviews here!
        //Also this is the way to filter an already loaded model, with the same logic as here

        //Caching the reviews the same way as in the index
        //Meaning that the reviews data that you see on a single book page will be served from a cache for an hour (3600 sec)
        //After that hour the new query to the database will be run for someone that visits this page and then will be stored for another hour
        $cacheKey = 'book:' . $id;
        $book = cache()->remember(
            $cacheKey,
            3600,
            fn() =>
            Book::with([
                'reviews' => fn($query) => $query->latest()
            ])->withAvgRated()->withReviewsCount()->findOrFail($id)
        );

        //with() is the way to fetch relations together with the Model at the same time

        return view('books.show', ['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
