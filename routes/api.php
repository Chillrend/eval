<?php

use App\Http\Controllers\BindProdiTesController;
use App\Http\Controllers\BindProdiPresController;
use App\Http\Controllers\BindProdiMandController;
use App\Http\Controllers\CandidateMandiriController;
use App\Http\Controllers\CandidatePresController;
use App\Http\Controllers\CandidateTesController;
use App\Http\Controllers\FilterMandiriController;
use App\Http\Controllers\FilterPresController;
use App\Http\Controllers\FilterTesController;
use App\Http\Controllers\PreviewMandiriController;
use App\Http\Controllers\PreviewPresController;
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

//Candidate Prestasi
Route::get('/candidates-prestasi', [CandidatePresController::class,'api_render'])->name('api_renderCanPres');
Route::post('/get-criteria-candidates-pres',[CandidatePresController::class,'criteria'])->name('criteriaCanPres');
Route::post('/candidates-prestasi/import', [CandidatePresController::class,'api_import'])->name('api_importCanPres');
Route::post('/candidates-prestasi/save', [CandidatePresController::class,'api_save'])->name('api_saveCanPres');
Route::post('/candidates-prestasi/cancel', [CandidatePresController::class,'api_cancel'])->name('api_cancelCanPres');

//Candidate Tes
Route::get('/candidates-tes', [CandidateTesController::class,'api_render'])->name('api_renderCanTes');
Route::post('/get-criteria-candidates-tes',[CandidateTesController::class,'criteria'])->name('criteriaCanTes');
Route::post('/candidates-tes/import', [CandidateTesController::class,'api_import'])->name('api_importCanTes');
Route::post('/candidates-tes/save', [CandidateTesController::class,'api_save'])->name('api_saveCanTes');
Route::post('/candidates-tes/cancel', [CandidateTesController::class,'api_cancel'])->name('api_cancelCanTes');

//Candidate Mandiri
Route::get('/candidates-mandiri', [CandidateMandiriController::class,'api_render'])->name('api_renderCanMan');
Route::post('/get-criteria-candidates-mandiri',[CandidateMandiriController::class,'criteria'])->name('criteriaCanMan');
Route::post('/candidates-mandiri/import', [CandidateMandiriController::class,'api_import'])->name('api_importCanMan');
Route::post('/candidates-mandiri/save', [CandidateMandiriController::class,'api_save'])->name('api_saveCanMan');
Route::post('/candidates-mandiri/cancel', [CandidateMandiriController::class,'api_cancel'])->name('api_cancelCanMan');


//Prodi Prestasi


//Prodi Tes
Route::get('/prodi-tes', [ProdiTesController::class, 'api_render'])->name('api_renderProTes');
Route::post('/prodi-tes/insert', [ProdiTesController::class, 'api_insert'])->name('api_insertProTes');
Route::post('/prodi-tes/delete', [ProdiTesController::class, 'api_delete'])->name('api_deleteProTes');
Route::post('/prodi-tes/edit', [ProdiTesController::class, 'api_edit'])->name('api_editProTes');

//Prodi Mandiri
Route::get('/prodi-mandiri', [ProdiMandiriController::class, 'api_render'])->name('api_renderPro');
Route::post('/prodi-mandiri/insert', [ProdiMandiriController::class, 'api_insert'])->name('api_insertPro');
Route::post('/prodi-mandiri/delete', [ProdiMandiriController::class, 'api_delete'])->name('api_deletePro');
Route::post('/prodi-mandiri/edit', [ProdiMandiriController::class, 'api_edit'])->name('api_editPro');



//Binding Prodi Prestasi
Route::get('/bind-prodi-prestasi', [BindProdiPresController::class,'render_api'])->name('api_renderBindProdiPres');
Route::post('/bind-prodi-prestasi/detail', [BindProdiPresController::class,'detail'])->name('api_detailBindProdiPres');
Route::post('/bind-prodi-prestasi', [BindProdiPresController::class,'binding'])->name('api_bindBindProdiPres');

//Binding Prodi Tes
Route::get('/bind-prodi-tes', [BindProdiTesController::class,'render_api'])->name('api_renderBindProdiTes');
Route::post('/bind-prodi-tes/detail', [BindProdiTesController::class,'detail'])->name('api_detailBindProdiTes');
Route::post('/bind-prodi-tes', [BindProdiTesController::class,'api_binding'])->name('api_bindBindProdiTes');

//Binding Prodi Mandiri
Route::get('/bind-prodi-mandiri', [BindProdiMandController::class,'render_api'])->name('api_renderBindProdiMand');
Route::post('/bind-prodi-mandiri/detail', [BindProdiMandController::class,'detail'])->name('api_detailBindProdiMand');
Route::post('/bind-prodi-mandiri', [BindProdiMandController::class,'api_binding'])->name('api_bindBindProdiMand');


//Preview Prestasi
Route::get('/preview-prestasi', [PreviewPresController::class, 'api_render'])->name('api_renderPreviewPres');

//Preview Tes
Route::get('/preview-tes', [PreviewTesController::class, 'api_render'])->name('api_renderPreviewTes');

//Preview Mandiri
Route::get('/preview-mandiri', [PreviewMandiriController::class, 'api_render'])->name('api_renderPreviewMand');


//Filter Prestasi
Route::post('/filter-pres', [FilterPresController::class,'save'])->name('saveFilterPres');
Route::post('/get-filter-pres', [FilterPresController::class,'getFilter'])->name('getFilterPres');

//Filter Tes
Route::get('/filter-tes', [FilterTesController::class,'api_render'])->name('api_renderFilterTes');
Route::post('/filter-tes', [FilterTesController::class,'api_save'])->name('saveFilterTes');
Route::post('/get-filter-tes', [FilterTesController::class,'getFilter'])->name('getFilterTes');

//Filter Mandiri
Route::post('/filter-mandiri', [FilterMandiriController::class,'save'])->name('saveFilterMan');
Route::post('/get-filter-mandiri', [FilterMandiriController::class,'getFilter'])->name('getFilterMan');









