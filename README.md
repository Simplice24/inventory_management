# Inventory Management System

-   This application is developed using laravel 8
-   php 8.0 or more needed

## Commands to active application

-   composer install / composer update
-   npm install
-   npm run dev
-   make env file and give command 'php artisan key:generate'
-   setup db and give command 'php artisan migrate --seed' or import backup db file

# Application Features

-   Laravel Spatie for Role and Permission Management.
-   Used Ajax for validating inventory requests.
-   Application has two parts, Raw Material Inventory & Production Material Inventory.
-   There have raw materials like oil (soyabean), oil (palm), cap, label, bottle, etc.
-   Create request for raw materials.
-   After confirming raw material requests stock will be updated.
-   Create request for production material.
-   After confirming production material requests stock of raw material and production material will be updated.

## Raw Material Inventory

-   Raw Material Requests is accessed by employees having specific (Raw Request Handler) Role.
-   If any single employee will cancell the request, it will be cancelled and will be denided from next process.
-   All employees having this role have to confirm requests to add Raw Products in stock.
-   Dynamic Request Confirmation system (when request is created, role is distributed among all employees having specific Role).

## Production Material Inventory

-   When creating new requests availability of raw material is being checked.
-   Production Material Requests is accessed by employees having specific (Production Request Handler) Role.
-   If any single employee will cancell the request, it will be cancelled and will be denided from next process.
-   When employees confirming requests stock availability will be checked and next process wil be start.
-   All employees having this role have to confirm requests to add Production Products in stock.
-   Dynamic Request Confirmation system (when request is created, role is distributed among all employees having specific Role).

# Login Details

-   admin: naymur@example.com
-   password: abcd1234
