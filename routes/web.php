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
Route::get('/admin/find','AdminController@find');
Route::get('/admin/pdf','AdminController@pdf');
Route::get('/admin/offer_received','AdminController@offer_received');
Route::get('/admin/offer_find','AdminController@offer_find');
Route::get('/admin/pdf_offer','AdminController@pdf_offer');
Route::get('/admin/application_report','AdminController@application_report');
Route::get('/admin/application_find','AdminController@application_find');
Route::get('/admin/pdf_application','AdminController@pdf_application');
Route::get('/admin/summary_report','AdminController@summary_report');
Route::get('/admin/summary_find','AdminController@summary_find');
Route::get('/admin/summary_pdf','AdminController@summary_pdf');
Route::get('/admin/excel','AdminController@excel');
Route::get('/admin/document','AdminController@document');
Route::get('/admin/document_find','AdminController@document_find');
Route::get('/admin/pdf_document','AdminController@pdf_document');
Route::get('/admin/document_excel','AdminController@document_excel');
Route::get('/admin/application_excel','AdminController@application_excel');
Route::get('/admin/offer_excel','AdminController@offer_excel');
Route::get('/admin/initial_excel','AdminController@initial_excel');


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

Route::get('/counselor/initial_enquiry','CounselorController@initial_enquiry');
Route::get('/counselor/find','CounselorController@find');
Route::get('/counselor/pdf','CounselorController@pdf');
Route::get('/counselor/offer_received','CounselorController@offer_received_all');
Route::get('/counselor/offer_find','CounselorController@offer_find');
Route::get('/counselor/pdf_offer','CounselorController@pdf_offer');
Route::get('/counselor/application_report','CounselorController@application_report');
Route::get('/counselor/application_find','CounselorController@application_find');
Route::get('/counselor/pdf_application','CounselorController@pdf_application');
Route::get('/counselor/summary_report','CounselorController@summary_report');
Route::get('/counselor/summary_find','CounselorController@summary_find');
Route::get('/counselor/summary_pdf','CounselorController@summary_pdf');
Route::get('/counselor/excel','CounselorController@excel');
Route::get('/counselor/document','CounselorController@document');
Route::get('/counselor/document_find','CounselorController@document_find');
Route::get('/counselor/pdf_document','CounselorController@pdf_document');
Route::get('/counselor/document_excel','CounselorController@document_excel');
Route::get('/counselor/application_excel','CounselorController@application_excel');
Route::get('/counselor/offer_excel','CounselorController@offer_excel');
Route::get('/counselor/initial_excel','CounselorController@initial_excel');

Route::get('/counselor/enquiry_edit_form','CounselorController@enquiry_edit_form');
Route::put('/counselor/enquiry_edit','CounselorController@enquiry_edit');
Route::get('/counselor/document_edit_form','CounselorController@document_edit_form');
Route::put('/counselor/document_edit','CounselorController@document_edit');
Route::get('/counselor/application_edit_form','CounselorController@application_edit_form');
Route::put('/counselor/application_edit','CounselorController@application_edit');
Route::get('/counselor/offer_edit_form','CounselorController@offer_edit_form');
Route::put('/counselor/offer_edit','CounselorController@offer_edit');


Route::get('/student','StudentController@student');

