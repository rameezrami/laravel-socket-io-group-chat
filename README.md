# laravel-pusher-group-chat
Laravel pusher groups chat

# Setup Laravel 5.7 API
  - Make sure [composer] is installed
  - Make sure you have PHP >= 7.1.3
  - Make sure your meets all the requirement specified in [laravel docs]
  - Clone Project
  - Create a new DB for the project
  - Copy .env.example file and rename to .env and set necessary ENV variables.
  - Setup QueueJob(in my case: sqs)
  - Setup Broadcast(in my case: pusher)
  - Follow below commands
    ```
    $ composer install
    $ php artisan migrate:fresh
    $ php artisan db:seed
    $ php artisan serve
    ```
Now it will start an API development server at http://localhost:8000


That's it!!!
----
    
   [composer]: <https://getcomposer.org/>
   [laravel docs]: <https://laravel.com/docs/5.7/installation#server-requirements>
