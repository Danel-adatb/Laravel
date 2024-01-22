#Project #2
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
     * In that moment it makes the query when it encounters (that property being accessed) - Amikor odaér a kód és lefuttatja parasztosan

