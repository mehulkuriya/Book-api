# Getting started

## Installation

Clone the repository

    git clone https://github.com/mehulkuriya/Book-api.git

Switch to the repo folder

    cd Book-api

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env  
    
    for windows 

    copy .env.example .env

Generate a new application key

    php artisan key:generate



Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate --seed

Start the local development server

    php artisan serve

You can now access the server at http://127.0.0.1:8000/


    
**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate
    php artisan serve

## Database seeding

**Populate the database with seed data with relationships which includes users, articles, comments, tags, favorites and follows. This can help you to quickly start testing the api or couple a frontend and start using it with ready content.**


Run the database seeder and you're done

    php artisan db:seed

***Note*** : It's recommended to have a clean database before seeding. You can refresh your migrations at any point to clean the database by running the following command

    php artisan migrate:refresh
    




The api can be accessed at [http://127.0.0.1:8000/api](http://127.0.0.1:8000/api).

## API Documentation

 To generate swagger api documentation execute below command 

    php artisan l5-swagger:generate

You can access api documentation using below url 

 http://127.0.0.1:8000/api/documentation



----------




## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

# Testing API

Run the laravel development server

    php artisan serve

The api can now be accessed at

   http://127.0.0.1:8000/api/


