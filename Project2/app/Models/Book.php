<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Book extends Model
{
    use HasFactory;

    public function reviews() {
        //Defines a one-to-many relationship between Book and Review models (tables)
        return $this->hasMany(Review::class);
    }

    //Query Scopes, you must name these with scopeSomething
    //Needs at least one argument!
    //(): Builder -> specified type hint, or return type
    //Tinker: \App\Models\Book::title('delectus')->get();
    //scope is prefixed and the Title has to be used without capital letter -> 'title()'
    public function scopeTitle(Builder $query, string $title): Builder {
        return $query->where('title', 'LIKE', '%'. $title . '%');
    }

    public function scopeWithReviewsCount(Builder $query, $from = null, $to = null): Builder|QueryBuilder {
        return $query->withCount([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ]);
    }

    public function scopeWithAvgRated(Builder $query, $from = null, $to = null): Builder|QueryBuilder {
        return $query->withAvg([
            'reviews' => fn(Builder $q) => $this->dateRangeFilter($q, $from, $to)
        ], 'rating');
    }

    //Most amount of reviews
    //Example: \App\Models\Book::popular('2023-01-01', '2023-04-01')->get();
    //fn() -> arrow function
    // - There can be only ONE expression inside them!
    // - No ';' is needed at the end
    // - You don't need to add the 'use ()' statement for outside variables
    public function scopePopular(Builder $query, $from = null, $to = null): Builder|QueryBuilder {
        return $query->withReviewsCount()->orderBy('reviews_count', 'desc');
    }

    //Examples: \App\Models\Book::popular()->highestRating()->get();
    //Example: \App\Models\Book::highestRating('2023-01-01', '2023-04-01')->get();
    //Highest rated books
    public function scopeHighestRating(Builder $query, $from = null, $to = null): Builder|QueryBuilder {
        return $query->withAvgRated()->orderBy('reviews_avg_rating', 'desc');
    }

    /* Scope that shows only Books that has a specified amount of reviews, because maybe a book is not 5.0 rated,
     * but there is just one rating that is a five
     */
    //When we are working with aggregate functions results we have to use 'having()'
    //Example: \App\Models\Book::highestRating('2023-01-01', '2023-04-01')->popular('2023-01-01', '2023-04-01')->minReviews(2)->get();
    public function scopeMinReviews(Builder $query, $minReviews): Builder|QueryBuilder {
        return $query->having('reviews_count', '>=', $minReviews);
    }

    //This is only for internal use, that's why its private
    private function dateRangeFilter(Builder $query, $from = null, $to = null) {
        if($from && !$to) {
            $query->where('created_at', '>=', $from);
        } elseif(!$from && $to) {
            $query->where('created_at', '<=', $to);
        } elseif($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    }

    public function scopePopularLastMonth(Builder $query): Builder|QueryBuilder {
        return $query->popular(now()->subMonth(), now())->highestRating(now()->subMonth(), now())->minReviews(2);
    }

    public function scopePopularLast6Months(Builder $query): Builder|QueryBuilder {
        return $query->popular(now()->subMonths(6), now())->highestRating(now()->subMonths(6), now())->minReviews(5);
    }

    public function scopeHighestRatingLastMonth(Builder $query): Builder|QueryBuilder {
        return $query->highestRating(now()->subMonth(), now())->popular(now()->subMonth(), now())->minReviews(2);
    }

    public function scopeHighestRatingLast6Months(Builder $query): Builder|QueryBuilder {
        return $query->highestRating(now()->subMonths(6), now())->popular(now()->subMonths(6), now())->minReviews(5);
    }

    protected static function booted() {

        static::updated(fn(Book $book) => cache()->forget('book:' . $book->id));
        static::deleted(fn(Book $book) => cache()->forget('book:' . $book->id));
    }
}
