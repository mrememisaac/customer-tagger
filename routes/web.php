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

Route::get('/', 'HomeController@welcome'); 

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/authorize_infusionsoft', 'InfusionsoftController@authorizeInfusionsoft')->name('infusionsoft.authorize');
Route::post('/authorize_infusionsoft', 'InfusionsoftController@authorizeInfusionsoft')->name('infusionsoft.authorize');

Route::get('/create_contact', 'InfusionsoftController@testInfusionsoftIntegrationCreateContact');
Route::get('/infusionsoft_test_get_by_email/{email}', 'InfusionsoftController@testInfusionsoftIntegrationGetEmail')->name('api.infusionsoft_test_email');
Route::get('/infusionsoft_test_add_tag/{contact_id}/{tag_id}', 'InfusionsoftController@testInfusionsoftIntegrationAddTag')->name('api.infusionsoft_test_tag');
Route::get('/infusionsoft_test_get_all_tags', 'InfusionsoftController@testInfusionsoftIntegrationGetAllTags')->name('api.infusionsoft_test_get_all_tags');

Route::get('/mcreate_contact', 'MockInfusionsoftController@testInfusionsoftIntegrationCreateContact');
Route::get('/minfusionsoft_test_get_by_email/{email}', 'MockInfusionsoftController@testInfusionsoftIntegrationGetEmail')->name('api.infusionsoft_test_email');
Route::get('/minfusionsoft_test_add_tag/{contact_id}/{tag_id}', 'MockInfusionsoftController@testInfusionsoftIntegrationAddTag')->name('api.infusionsoft_test_tag');
Route::get('/minfusionsoft_test_get_all_tags', 'MockInfusionsoftController@testInfusionsoftIntegrationGetAllTags')->name('api.infusionsoft_test_get_all_tags');