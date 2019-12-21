<?php


/**
 *  get list of categories
 */
Route::GET('categories', 'CategoryController@index')->name('category.index');


/**
 *  get one category
 */
Route::GET('categories/{slug}', 'CategoryController@show')->name('category.show');


/**
 * Create a category
 */
Route::POST('categories', 'CategoryController@store')->name('category.store');


/**
 * Update a category
 */
Route::PUT('categories/{slug}', 'CategoryController@update')->name('category.update');


/**
 * Delete category
 */
Route::Delete('categories/{slug}','CategoryController@destroy')->name('category.delete');

