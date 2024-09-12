<?php

use App\Http\Controllers\Api\studentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/students', [studentController::class, 'index']);

Route::get('/students/{id}', [studentController::class, 'show']);//por si solo quiere llamar un estudiante

Route::post('/students', [studentController::class, 'store']);

Route::put('/students/{id}',[studentController::class, 'update']); //se ponen las llaves {} para especificar el id del estudiante que se va a actualizar

Route::patch('/students/{id}',[studentController::class, 'updatePartial']); //se ponen las llaves {} para especificar el id del estudiante que se va a actualizar parcialmente

Route::delete('/students/{id}', [studentController::class, 'destroy']);//se ponen las llaves {} para especificar el id del estudiante que se va a eliminar
