<?php


/**
 *  get list of categories
 */
Route::GET('category', 'CategoryController@index')->name('category.index');


/**
 *  get one category
 */
Route::GET('category/{id}', 'CategoryController@index')->name('category.index');


/**
 * Create a category
 */
Route::POST('category', 'CategoryController@store')->name('category.store');


/**
 * Delete category
 */
Route::Delete('category/{id}','CategoryController@destroy')->name('category.delete');

