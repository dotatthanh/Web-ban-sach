<?php

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', 'TypeController@index')->name('home');

Route::group(['prefix' => 'admin'], function(){
	Route::resource('books', 'BookController');
	Route::resource('authors', 'AuthorController');
	Route::resource('types', 'TypeController');
	Route::resource('categorys', 'CategoryController');
	Route::resource('orders', 'OrderController');
	Route::resource('news', 'NewController');
	Route::resource('contacts', 'ContactController');
	Route::resource('warehouses', 'WarehouseController');


	Route::group(['prefix' => 'statistic'], function(){
		Route::get('book', 'StatisticController@bookStatistic')->name('book-statistic');
	});
});


Route::resource('pages', 'PageController');
Route::prefix('page')->name('page.')->group(function(){
	Route::get('category/{id}', 'PageController@category')->name('category');
	
	Route::get('category_selling', 'PageController@category_selling')->name('category_selling');
	Route::get('category_sale', 'PageController@category_sale')->name('category_sale');
	Route::get('category_new', 'PageController@category_new')->name('category_new');
	Route::get('tophighlight', 'PageController@tophighlight')->name('tophighlight');
	Route::get('forum', 'PageController@forum')->name('forum');
	Route::get('forum-detail/{id}', 'PageController@forum_detail')->name('forum-detail');


	Route::get('add-to-cart/{id}/{name}', 'PageController@add_to_cart')->name('add-to-cart');
	Route::get('del-product-cart/{id}', 'PageController@del_product_cart')->name('del-product-cart');

	Route::get('del-cart', 'PageController@del_cart')->name('del-cart');

	Route::get('update-product-cart/{rowid}/{qty}', 'PageController@update_product_cart')->name('update-product-cart');
	Route::post('order', 'PageController@order')->name('order');


	Route::get('contact', 'PageController@contact')->name('contact');
	Route::post('send_us', 'PageController@send_us')->name('send_us');

	Route::get('search', 'PageController@search')->name('search');
});