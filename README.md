#Project #2 Tipps and Tricks (Project 3 is on the Lenovo, Project 1 and 2 is on the Desktop!!!!!)
- When you only need a few datas from the database use 'lazy loading'
- Eager loading is needed when you care about the performance, need 100 of records OR you know you will need related data (reviews for the books) OR minimizing the query runs for the database
- php artisan tinker ... you can use the Models query (find(), reviews, etc...)
- protected $fillable = []; -> its a property in a Model that lets you specify, that these can be mass assigned
- toSql() -> what was the actual query that has been run
- Local query scopes -> writing SQL with help of Laravel, in the Models -> scopeSomething($argument)....

- Some refresh:
-   php artisan make:controller ExampleController ----- to make a contorller in Laravel, this is where the logic is (App\Http\Controllers
-   You handle here the request by writing methods (actions)
-   You can create the logic inside the web.php file -> okay with smaller applications, but if you work on big projects lets use Controller classes for that Controller logic
-   It's job to glue together the Models and the Views
-   Models handle data
-   View is the outlook --- that is all called MVC pattern

-   php artisan route list ----- to check all the routes in your application

-   php artisan make:controller ExampleController --resources ------ is the what so called resource controller, that has some predefined set of methods (actions)
-   For Example: index, show, create, store, etc...
-   Route names are automatically is created for you example.store, example.show, etc...
-   Implementing them: Route::resource('books', BookController::class);
-   Also supports nested routes (for example you read reviews that are attached to books) -> it will be easy to create URLs that reflect that
-   Also allows partial resource routes
-   You should use resource controllers always ALL THE TIME in Laravel

-   The lazy loading:
     * When we access the relationship name by the property name, not by a method (for example: foreach($book->reviews as $review))
     * Laravel will lazy load all the related relations of a particual book
     * In that moment it makes the query when it encounters (that property being accessed) - Amikor odaér a kód és lefuttatja parasztosa
 
- Caching:
    * Mechanism of storing some information in some temporary storage
    * More efficient then a main storage
    * Takes up big resources of your for example CPU to retreive this data every single time
    * This is the case where we use cache
    * So it doesn't change that often, for eaxmple using just a plain key
 
    * In a relational database we only use a single key, and bypassing this key we retrieve data which often is kept inside a memory that is super fast
 
    * Can be applied to: routing, blade rendering (internally, wouldn't even noticing), database actions
    * We can use it explicitily in this project
 
    * For example Redis or Memcached that are key value stores and gives fast access to the data
 
    * We need to invalidate the cache when for example a data is changed in the database, so we have to display the new data immediately (Eloquent: Events on the Laravel page)

 - Components:
    * You don't have to register this template, you can use it in any Blade php page wherever you want
    * Components are very good for:
    * Reusing
    * Passing data to them
  
- Scoping of resource routes
    * For example a resource controller can be used, but we don't have the review relation by itself, meaning, as a normal controller it cannot be connected to a Model that doesn't exist, in this case we use the Scope resource Route
    * Laravel configures out the connection between Reviews and Book

- Rate limiting
    * We create a rate limiting on RouteServiceProvider.php, and then in ReviewController we apply this limiter to the store method
    * For the RouteServiceProvider.php (aka Rate limiter) we have to specify a construct
    * We can also define different groups, for example 3 reviews posted in every hour, or 1 book per day.... etc.
    * Rate limiting is often used with APIs, to not overuse your system
