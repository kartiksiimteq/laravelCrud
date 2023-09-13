<?php

use App\Http\Controllers\EmployeeApiV1Controller;
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

Route::middleware( 'auth:sanctum' )->get( '/user', function ( Request $request ) {
    return $request->user();
} );


Route::group( [ 'prefix' => 'v1' ], function () {
    Route::apiResource( 'employees', EmployeeApiV1Controller::class );
    Route::put( 'employees/{id}', [EmployeeApiV1Controller::class,'update'] );
} );
