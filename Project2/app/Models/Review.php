<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    //Lets you specify that these can be mass assigned
    protected $fillable = ['review', 'rating'];

    public function book() {
        return $this->belongsTo(Book::class);
    }

    //Registering events for invalidating cache
    //For example we have this event when we have to invalidate the cache because the datas were UPDATED
    //Whenever the review model is modified, this event will be triggered
    //The modification has to happen on a Model NOT inside the database because then it wont be triggered
    // NOT TRIGGERING:
    // 1. modifying database wont trigger this event
    // 2. mass assignment (update method on a Model), won't trigger this event! -> it just runs the query directly it doesn't fetch the Model
    // 3. using raw SQL query inside Laravel, won't trigger this event
    protected static function booted() {
        //For example when a review was updated, we want to clear the cache of the book, beacuse the reviews are relational to book Model
        // which mean, for example $book->review, we get this way the reviews, that's why we do the cache invalidating here
        //'book:' is the cacheKey that we used previously
        //Also most efficient way to load the ID from the review table ($review->book_id), because if we would load the data form the ...
        // ... Book table, we would use Laravel's lazy loading which is not so efficient: for example - $review->book->id OR ....->title, etc.

        static::updated(fn(Review $review) => cache()->forget('book:' . $review->book_id));
        static::deleted(fn(Review $review) => cache()->forget('book:' . $review->book_id));
        static::created(fn(Review $review) => cache()->forget('book:' . $review->book_id));
    }
}
