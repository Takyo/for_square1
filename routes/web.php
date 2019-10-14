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
/**
 * authentication
 */
Auth::routes();

/**
 * products
 */
// Route::resource('/products', 'ProductController');
Route::redirect('/home', '/products');
Route::get('/products', 'ProductController@index');
Route::get('/', 'ProductController@index');

/**
 * wishlist
 */
Route::get('{user_id}/wishlist' , 'WishlistController@index')->name('user.wishlist');
Route::get('/wishlist/show/{wishlist_id}' , 'WishlistController@show')->name('wishlist.show');

Route::get('wishlist/new' , 'WishlistController@create')->name('wishlist.create');
Route::post('wishlist/store' , 'WishlistController@store')->name('wishlist.store');
Route::post('wishlist/ajax/store' , 'WishlistController@storeAjax')->name('wishlist.ajax.store');

Route::get('wishlist/edit/{wishlist_id}' , 'WishlistController@edit')->name('wishlist.edit');
Route::put('wishlist/update/{wishlist_id}' , 'WishlistController@update')->name('wishlist.update');
Route::put('wishlist/update/ajax/{wishlist_id}' , 'WishlistController@updateAjax')->name('wishlist.ajax.update');

Route::delete('wishlist/del/{wishlist_id}' , 'WishlistController@destroy')->name('wishlist.delete');

route::put('wishlist/{wishlist_id}/product/{product_id}/detach', 'WishlistController@detachProduct')->name('wishlist.ajax.product.detach');