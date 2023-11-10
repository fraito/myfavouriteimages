# My Favourite images APP

Application developed on a frontend consuming data from a backend through a REST API.

## Requirements:

* As a user it will be necessary to be able to see a list of my images (image and a title).
* As a user it will be necessary to be able to add images to a database (saving the URL, local storage will not be necessary)
* As a user it will be necessary to be able to delete an image.
* As a user it will be necessary to be able to edit an existing image.

***

## Backend

### Previous requirements:
* PHP >=8.1
* [Composer](https://getcomposer.org/).
* A database

### Installation
* Navigate to *backend* folder
* copy *.env.example* to *.env* and change your database connection details (DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).
* Then execute the following commands:

```
composer install

npm install

php artisan migrate

php artisan key:generate

php artisan jwt:secret
```

* To start the server execute `php artisan serve`

### Tests

In backend folder execute `php artisan test`