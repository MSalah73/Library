<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('books.index');
});

// BookController
Route::get('/book', 'BooksController@index')->name('books.index');
Route::post('/book', 'BooksController@store')->name('books.store');
Route::patch('/book/{book}', 'BooksController@update')->name('books.update');
Route::get('/book/{book}/edit', 'BooksController@edit')->name('books.edit');
Route::delete('/book/{book}', 'BooksController@destroy')->name('books.destory');
Route::get('/book/search', 'BooksController@search')->name('books.search');

// Exports Routes
Route::get('book/export/', 'BooksController@export')->name('books.export');