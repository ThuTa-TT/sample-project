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

//department
Route::apiResource('/departments','DepartmentController');
Route::delete('/departments/forcedelete/{id}','DepartmentController@forcedelete');
Route::post('/departments/search','DepartmentController@search');//department serach



//positons
Route::apiResource('/positions','PositionController');
Route::delete('/positions/forcedelete/{id}','PositionController@forcedelete');


//employees
Route::apiResource('/employees','EmployeeController');
Route::delete('/employees/forcedelete/{id}','EmployeeController@forcedelete');
Route::post('/employees/search','EmployeeController@search');//employee serach


//department_position
Route::apiResource('/deparment_positions','DepPosController');

//file employee export,import,pdf
Route::post('/employee-import', 'EmployeeController@fileImport');
Route::get('/employee-export', 'EmployeeController@fileExport');
Route::get('/employee-pdf','EmployeeController@createPDF');

//emp_registration
Route::get('save','EmpRegistrationCOntroller@save');
Route::post('update','EmpRegistrationCOntroller@update');

//pos_registration
Route::get('savepos','PositionRegistrationController@save');
