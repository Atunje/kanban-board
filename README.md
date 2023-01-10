# Kanban Board Backend

----------

# Getting started

## Installation

Clone the repository

    git clone git@github.com:Atunje/kanban-board.git


Switch to the repo folder

    cd kanban-board

Install dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000/api

**TL;DR command list**

    git clone git@github.com:Atunje/kanban-board.git
    cd kanban-board
    composer install
    cp .env.example .env
    php artisan key:generate

**Make sure you set the correct database connection information before running the migrations**

    php artisan migrate
    php artisan serve

# Code overview

## Dev Dependencies

- [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)
- [nunomaduro/larastan](https://github.com/nunomaduro/larastan)
- [nunomaduro/phpinsights](https://github.com/nunomaduro/phpinsights)

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers` - Contains all the controllers
- `app/Http/Middleware` - Contains the middlewares
- `app/Http/Requests` - Contains all the api form requests
- `app/Http/Resources` - Contains all the api resource files
- `app/Http/Services` - Contains the services
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `routes` - Contains all the api routes
- `tests/Feature` - Contains the api tests

## Documentation

The api documentation can be accessed at [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation).
