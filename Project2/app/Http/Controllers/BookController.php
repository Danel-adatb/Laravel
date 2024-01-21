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
        //If the $title is null it won't run the function, othervise it will (when() method's logic)
        $books = Book::when(
            $title,
            fn($query, $title) => $query->title($title)
        )->get();

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
