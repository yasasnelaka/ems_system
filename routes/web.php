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
Route::get('/admin/initial_enquiry','AdminController@initial_enquiry');

Route::get('/counselor','CounselorController@counselor');
Route::get('/counselor/register','CounselorController@student_register_form');
Route::post('/counselor/student/register','CounselorController@student_register');
Route::get('/counselor/document_received_form','CounselorController@document_received_form');
Route::get('/counselor/document_received_check','CounselorController@document_received_check');
Route::post('/counselor/document_received','CounselorController@document_received');
Route::get('/counselor/application_received_form','CounselorController@application_received_form');
Route::post('/counselor/application_received','CounselorController@application_received');
Route::get('/counselor/offer_received_form','CounselorController@offer_received_form');
Route::post('/counselor/offer_received','CounselorController@offer_received');

Route::get('/student','StudentController@student');

