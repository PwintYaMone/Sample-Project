<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {

    return $request->user();
});

//Employee
Route::apiResource('/employees','EmployeeController');
Route::Delete('/employees/force/{id}','EmployeeController@forcedelete');
Route::POST('/employees/search','EmployeeController@search');
Route::get('/employee/export', 'EmployeeController@fileExport')->name('file-export'); 
Route::post('/employee/import', 'EmployeeController@fileImport')->name('file-import'); 


//Department
Route::apiResource('/departments','DepartmentController');
Route::Delete('/departments/force/{id}','DepartmentController@forcedelete');
Route::get('/department/export', 'DepartmentController@fileExport')->name('file-export'); 
Route::post('/department/import', 'DepartmentController@fileImport')->name('file-import'); 


//Position
Route::apiResource('/positions','PositionController');
Route::Delete('/positions/force/{id}','PositionController@forcedelete');

//Department position
Route::apiResource('/deparment_positions','DeppositionController');









