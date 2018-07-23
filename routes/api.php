<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([/*'middleware' => ['auth:api']*/], function(){
    Route::get('employees/root', 'Api\EmployeeController@root');
    Route::get('employees/{id}/children', 'Api\EmployeeController@children');
    Route::resource('employees', 'Api\EmployeeController', ['except' => ['create', 'edit']]);

});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
