<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('API\Admin')->as('api.admin.')->group( function ()  {
    $real_path = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'admin_route' . DIRECTORY_SEPARATOR;
    include_once($real_path . 'category.php');
    include_once($real_path . 'course.php');
});
