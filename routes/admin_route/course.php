<?php


/**
 *  get list of courses
 */
Route::GET('courses', 'CourseController@index')->name('course.index');


/**
 *  get one course
 */
Route::GET('courses/{slug}', 'CourseController@show')->name('course.show');


/**
 * Create a course
 */
Route::POST('courses', 'CourseController@store')->name('course.store');


/**
 * Update a course
 */
Route::PUT('courses/{slug}', 'CourseController@update')->name('course.update');


/**
 * Delete course
 */
Route::Delete('courses/{slug}','CourseController@destroy')->name('course.delete');
