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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin','AdminController@admin');
Route::get('/admin/report','AdminController@report');
Route::get('/admin/edit','AdminController@edit');
Route::post('/admin/edit/register','AdminController@edit_register');

Route::get('/counselor','CounselorController@counselor');
Route::get('/counselor/register','CounselorController@student_register_form');
Route::post('/counselor/student/register','CounselorController@student_register');

Route::get('/student','StudentController@student');

