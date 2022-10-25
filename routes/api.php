<?php

use App\Http\Controllers\Api\ProdiController;
use App\Http\Controllers\CandidateMandiriController;
use App\Http\Controllers\CandidatePresController;
use App\Http\Controllers\CandidateTesController;
use App\Http\Controllers\ProdiMandiriController;
use App\Http\Controllers\ProdiPresController;
use App\Http\Controllers\ProdiTesController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/get-criteria-candidates-pres',[CandidatePresController::class,'criteria'])->name('criteriaCanPres');
Route::post('/del-criteria-candidates-pres',[CandidatePresController::class,'delcriteria'])->name('delcriteriaCanPres');

Route::post('/get-criteria-prodi-pres',[ProdiPresController::class,'criteria'])->name('criteriaProPres');

Route::post('/get-criteria-candidates-tes',[CandidateTesController::class,'criteria'])->name('criteriaCanTes');

Route::post('/get-criteria-prodi-tes',[ProdiTesController::class,'criteria'])->name('criteriaProTes');

Route::post('/get-criteria-candidates-mandiri',[CandidateMandiriController::class,'criteria'])->name('criteriaCanMan');

Route::post('/get-criteria-prodi-mandiri',[ProdiMandiriController::class,'criteria'])->name('criteriaProMan');
