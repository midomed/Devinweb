<?php


/**
 *  get list of courses
 */
Route::GET('course', 'CourseController@index')->name('course.index');


/**
 *  get one course
 */
Route::GET('course/{id}', 'CourseController@index')->name('course.index');


/**
 * Create a course
 */
Route::POST('course', 'CourseController@store')->name('course.store');


/**
 * Delete course
 */
Route::Delete('course/{id}','CourseController@destroy')->name('course.delete');