<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes(['register' => false]);


Route::get('', 'HomeController@index')->name('index');
Route::get('nggawe', 'BuilderController@index')->name('nggawe');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::resource('post','PostController');
Route::match(['get', 'post'], 'post/show','PostController@show')->name('post.show');
Route::post('post/deletemass','PostController@deletemass')->name('post.deletemass');

Route::resource('rubrik','CategoryController');
Route::match(['get', 'post'], 'rubrik/show','CategoryController@show')->name('rubrik.show');
Route::post('rubrik/deletemass','CategoryController@deletemass')->name('rubrik.deletemass');

Route::resource('userlist','UserlistsController');
Route::match(['get', 'post'], 'userlist/show','UserlistsController@show')->name('userlist.show');
Route::post('userlist/deletemass','UserlistsController@deletemass')->name('userlist.deletemass');

Route::resource('infografik','InfoGrafikController');
Route::match(['get', 'post'], 'infografik/show','InfoGrafikController@show')->name('infografik.show');
Route::post('infografik/deletemass','InfoGrafikController@deletemass')->name('infografik.deletemass');

Route::any('ajak/infografik','AjakController@infografik')->name('ajak.infografik');