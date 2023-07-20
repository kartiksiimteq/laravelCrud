<?php

use App\Http\Controllers\employeeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [employeeController::class, 'index'])->name('employe.index');

Route::get('/create', [employeeController::class, 'create'])->name('employe.create');
Route::post('/create/store', [employeeController::class, 'createStore'])->name('employe.createStore');
Route::get('delete/{id}', [employeeController::class, 'delete'])->name('employe.delete');
Route::get('/employee/{id}', [employeeController::class, 'fetchOne'])->name('employe.fetchone');
Route::post('/update', [employeeController::class, 'update'])->name('employe.update');
// Route::delete('Up/{id}', [employeeController::class, 'createStore'])->name('employe.createStore');