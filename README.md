#Project #2
- When you only need a few datas from the database use 'lazy loading'
- Eager loading is needed when you care about the performance, need 100 of records OR you know you will need related data (reviews for the books) OR minimizing the query runs for the database
- php artisan tinker ... you can use the Models query (find(), reviews, etc...)
