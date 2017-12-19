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

Route::get('/', 'ListController@show');
Auth::routes();

Route::get('/deleteall', 'ListController@deleteAll');
					/// ADMIN PANEL ///

Route::get('wanttoseeprofile/edituser/{uid}', 'AdminController@editUserInfo');
Route::post('wanttoseeprofile/edituser/editusersubmit', ['as' => 'editusersubmit', 'uses' => 'AdminController@editUser']);

Route::get('wanttoseeprofile/edituserdue/{uid}', 'AdminController@editUserDueInfo');
Route::post('wanttoseeprofile/edituserdue/edituserduesubmit', ['as' => 'edituserduesubmit', 'uses' => 'AdminController@editUserDue']);

/// Add New User
Route::get('/adduser', 'AdminController@takeUserInfo');
Route::post('addusersubmit', ['as' => 'addusersubmit', 'uses' => 'AdminController@insertUser']);

/// Add New Product
Route::get('/addproduct', 'AdminController@takeProductInfo');
Route::post('addproductsubmit', ['as' => 'addproductsubmit', 'uses' => 'AdminController@insertProduct']);

/// Add New Category
Route::get('/addcat', 'AdminController@takeCatInfo');
Route::post('addcatsubmit', ['as' => 'addcatsubmit', 'uses' => 'AdminController@insertCat']);

			/// Home and product features ///
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/categories', 'CategoryController@showAllCategories');
Route::get('/storage', 'ProductController@showAllStorage');
Route::get('storage/{ucat_id}', 'ProductController@showAllStorageCat');
Route::get('/product', 'ProductController@showAllProduct');
Route::get('product/{ucat_id}', 'ProductController@showAllProductCat');
Route::get('/productinfo/{pid}', 'ProductController@showProductInfo');

							/// BUY ROUTES ///

/// Proceed to page buy
Route::get('/proceedtobuy', 'InsertCustomerDataController@buyDataUser');
/// Selecting the user go to order page
Route::get('wanttobuy/{uid}', 'InsertCustomerDataController@insertDataToBuy');
Route::get('wanttobuy/removerorder/{uid}/{oid}', 'InsertCustomerDataController@removeBuyOrder');

/// Update a new buy order for a user
Route::post('wanttobuy/updatebuyorder/{uid}', ['as' => 'updatebuyorder', 'uses' => 'InsertCustomerDataController@insertNewBuyOrder']);
/// Show the confirm page listing all orders
Route::get('wanttobuy/conformbuyorder/{uid}', 'ProductController@buyProductConfirmation');
/// Confirm and update all the orders of current user
Route::post('wanttobuy/conformbuyorder/buyitemconfirm', ['as' => 'buyitemconfirm', 'uses' => 'ProductController@buyProduct']);


							/// SELL ROUTES ///

/// Proceed to page Sell
Route::get('/proceedtosell', 'InsertCustomerDataController@sellDataUser');
/// Selecting the user go to order page
Route::get('wanttosell/{uid}', 'InsertCustomerDataController@insertDataToSell');
Route::get('wanttosell/removerorder/{uid}/{oid}', 'InsertCustomerDataController@removeSellOrder');

/// Update a new sell order for a user
Route::post('wanttosell/updatesellorder/{uid}', ['as' => 'updatesellorder', 'uses' => 'InsertCustomerDataController@insertNewSellOrder']);
/// Show the confirm page listing all orders
Route::get('wanttosell/conformsellorder/{uid}', 'ProductController@sellProductConfirmation');
/// Confirm and update all the orders of current user
Route::post('wanttosell/conformsellorder/sellitemconfirm', ['as' => 'sellitemconfirm', 'uses' => 'ProductController@sellProduct']);
Route::get('success', 'InsertCustomerDataController@successfullUpdate');



							/// USER PROFILE ROUTES ///

Route::get('/userlist', 'ProfileController@listUsers');
Route::get('wanttoseeprofile/{uid}', 'ProfileController@showProfile');


							/// STATISTICS ROUTES ///

Route::get('/sellhistory', 'ShowStatisticController@showSellHistory');
Route::get('/buyhistory', 'ShowStatisticController@showBuyHistory');
Route::get('/duehistory', 'ShowStatisticController@showDueHistory');