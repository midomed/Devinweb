<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

##  API :
 API that allows you to manage categories and courses.
## Features  - CRUD endpoints (Create / Read / Update / Delete) categories/courses
  To install the dependencies of the project, you can use the composer

```composer install```

Create and modify the .env file to suit your needs
```APP_NAME=Laravel
   APP_ENV=local
   APP_KEY=base64:nIDaojkuNa8AWhnnL06N1oClsRfIZvm+Fc0LvOrF7l0=
   APP_DEBUG=true
   APP_URL=http://localhost
   
   LOG_CHANNEL=stack
   
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=devinweb
   DB_USERNAME=root
   DB_PASSWORD=
```
and run cmd to generate your key 
```php artisan key:generate```

When you have the .env with your database connection set up you can run your migrations & seders

```php artisan migrate:refresh --seed```
## Documentation
Navigate to url : Markup : https://documenter.getpostman.com/view/1914875/SWDzeg1c?version=latest#54811450-8db5-435a-bfed-37f450631a0f
