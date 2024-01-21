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
-   Models handle data
-   View is the outlook --- that is all called MVC pattern
