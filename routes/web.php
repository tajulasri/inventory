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
    return redirect()->route('login');
});

Auth::routes();
Route::get('/home', 'HomeController@index');
Route::resource('item','ItemController');
Route::resource('order','OrderController');
Route::resource('category','CategoryController');
Route::resource('request-item','RequestItemController');

Route::get('assign-stock',['uses' => 'ItemController@stock','as' => 'stock.index']);
Route::post('assign-stock',['uses' => 'ItemController@saveStock','as' => 'stock.store']);

Route::get('/complete',['uses' => 'OrderController@completed','as' => 'order.complete']);

Route::get('client/order/{slug}',['uses' => 'OrderController@order','as' => 'orderform.index']);
Route::post('client/order/{slug}',['uses' => 'OrderController@saveOrder','as' => 'orderform.store']);


Route::get('client/request-item',['uses' => 'RequestItemController@index','as' => 'request-item.index']);
Route::post('client/request-item',['uses' => 'RequestItemController@store','as' => 'request-item.store']);

Route::get('image/source',['uses' => 'HomeController@streamImage','as' => 'image.stream']);