<?php

use App\Http\Controllers\Api\ProdiController;
use App\Http\Controllers\BindProdiTesController;
use App\Http\Controllers\BindProdiPresController;
use App\Http\Controllers\BindProdiMandController;
use App\Http\Controllers\BobotController;
use App\Http\Controllers\CandidateMandiriController;
use App\Http\Controllers\CandidatePresController;
use App\Http\Controllers\CandidateTesController;
use App\Http\Controllers\FilterMandiriController;
use App\Http\Controllers\FilterPresController;
use App\Http\Controllers\FilterTesController;
use App\Http\Controllers\PreviewTesController;
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
Route::post('/get-criteria-candidates-tes',[CandidateTesController::class,'criteria'])->name('criteriaCanTes');
Route::post('/get-criteria-candidates-mandiri',[CandidateMandiriController::class,'criteria'])->name('criteriaCanMan');

Route::get('/preview-tes', [PreviewTesController::class, 'render_api'])->name('api_renderPreviewTes');

Route::post('/filter-mandiri', [FilterMandiriController::class,'save'])->name('saveFilterMan');
Route::post('/get-filter-mandiri', [FilterMandiriController::class,'getFilter'])->name('getFilterMan');

Route::post('/filter-tes', [FilterTesController::class,'save'])->name('saveFilterTes');
Route::post('/get-filter-tes', [FilterTesController::class,'getFilter'])->name('getFilterTes');

Route::post('/filter-pres', [FilterPresController::class,'save'])->name('saveFilterPres');
Route::post('/get-filter-pres', [FilterPresController::class,'getFilter'])->name('getFilterPres');

Route::get('/bind-prodi-tes', [BindProdiTesController::class,'render_api'])->name('api_renderBindProdiTes');
Route::post('/bind-prodi-tes/detail', [BindProdiTesController::class,'detail'])->name('api_detailBindProdiTes');
Route::post('/bind-prodi-tes', [BindProdiTesController::class,'binding'])->name('api_bindBindProdiTes');

Route::get('/bind-prodi-prestasi', [BindProdiPresController::class,'render_api'])->name('api_renderBindProdiPres');
Route::post('/bind-prodi-prestasi/detail', [BindProdiPresController::class,'detail'])->name('api_detailBindProdiPres');
Route::post('/bind-prodi-prestasi', [BindProdiPresController::class,'binding'])->name('api_bindBindProdiPres');

Route::get('/bind-prodi-mandiri', [BindProdiMandController::class,'render_api'])->name('api_renderBindProdiMand');
Route::post('/bind-prodi-mandiri/detail', [BindProdiMandController::class,'detail'])->name('api_detailBindProdiMand');
Route::post('/bind-prodi-mandiri', [BindProdiMandController::class,'binding'])->name('api_bindBindProdiMand');

Route::get('/pembobotan/tahun', [BobotController::class, 'getTahun'])->name('api_tahunBobot');
Route::post('/pembobotan/pend', [BobotController::class, 'getPend'])->name('api_pendBobot');
Route::post('/pembobotan/tahap', [BobotController::class, 'getTahap'])->name('api_tahapBobot');
Route::post('/pembobotan/kolom', [BobotController::class, 'render_api'])->name('api_dataBobot');
Route::post('/pembobotan/nilai', [BobotController::class, 'getnilai'])->name('api_nilaiBobot');
