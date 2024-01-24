<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class ReviewController extends Controller
{

    //For the RouteServiceProvider.php (aka Rate limiter) we have to specify a construct
    //We can also define different groups, for example 3 reviews posted in every hour, or 1 book per day.... etc.
    public function __construct() {
        $this->middleware('throttle:reviews')->only(['store']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function create(Book $book)
    {
        return view('books.reviews.create', ['book' => $book]);
    }

    public function store(Request $request, Book $book)
    {
        $data = $request->validate([
            'review' => 'required|min:15',
            'rating' => 'required|min:1|max:5|integer'
        ]);

        //It will create a new instance of a review and automatically associated with that specific book
        //Also creates a new model and stores it in the database
        $book->reviews()->create($data);

        return redirect()->route('books.show', $book)->with('success', 'Review added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
