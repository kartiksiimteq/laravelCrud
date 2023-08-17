<?php

use App\Http\Controllers\employeeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [employeeController::class, 'index'])->name('employe.index');

Route::get('/create', [employeeController::class, 'create'])->name('employe.create');
Route::post('/create/store', [employeeController::class, 'createStore'])->name('employe.createStore');
Route::get('delete/{id}', [employeeController::class, 'delete'])->name('employe.delete');
Route::get('/employee/{id}', [employeeController::class, 'fetchOne'])->name('employe.fetchone');
Route::post('/update', [employeeController::class, 'update'])->name('employe.update');
Route::get('/ajaxfetch', [employeeController::class, 'ajaxFetch'])->name('employe.ajaxfetch');
Route::get('/pdfDownload', [employeeController::class, 'pdfDownload'])->name('employe.pdfDownload');
Route::get('/test', [employeeController::class, 'test'])->name('employe.test');
Route::get('/testRequest', [employeeController::class, 'testRequest'])->name('employe.Request');

// Route::delete('Up/{id}', [employeeController::class, 'createStore'])->name('employe.createStore');
