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
    return redirect('/login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    // Home
    Route::get('/home', 'HomeController@index')->name('home');

    // Building
    Route::get('/building', 'BuildingController@index');
    Route::prefix('building')->group(function() {
        Route::post('/store', 'BuildingController@store');
        Route::post('/update/{id}', 'BuildingController@update');
        Route::post('/deactivate/{id}', 'BuildingController@deactivate');
        Route::post('/activate/{id}', 'BuildingController@activate');
    });

    // Role & Permission
    Route::get('/roles','RoleController@index');
    Route::prefix('roles')->group(function() {
        Route::post('/store','RoleController@store');
        Route::post('/update/{id}','RoleController@update');
        Route::post('/store-role-permission','RoleController@storeRolePermission');

        Route::get('/show/{id}','RoleController@show');
    });
    Route::prefix('permissions')->group(function() {
        Route::post('/store','RoleController@storePermission');
        Route::post('/update/{id}','RoleController@updatePermission');
    });

    // User
    Route::get('/users','UserController@index');
    Route::prefix('users')->group(function() {
        Route::post('/store', 'UserController@store');
        Route::post('/update/{id}', 'UserController@update');
        Route::post('/deactivate/{id}', 'UserController@deactivate');
        Route::post('/activate/{id}', 'UserController@activate');
    });

    // Corrective
    Route::get('corrective','CorrectiveController@index');
    Route::prefix('corrective')->group(function() {
        Route::post('/store', 'CorrectiveController@store');
        Route::post('/update/{id}', 'CorrectiveController@update');
        Route::post('/cancel/{id}', 'CorrectiveController@cancelled');
        Route::post('/update-status','CorrectiveController@updateStatus');
        Route::get('/show/{id}','CorrectiveController@show');
        Route::post('/comments/{id}','CorrectiveController@comment');
        Route::post('/attach-comments/{id}','CorrectiveController@attachComment');
        Route::post('/assign/{id}','CorrectiveController@assign');
    });

    // Corrective Board
    Route::get('corrective-board', 'CorrectiveBoardController@index');
    Route::prefix('corrective-board')->group(function() {
        Route::post('/store','CorrectiveBoardController@store');
        Route::get('/show/{id}','CorrectiveBoardController@show');
    });
});
