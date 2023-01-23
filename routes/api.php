<?php

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
use App\Http\Controllers\FinishController;
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
Route::get('/candidates-prestasi', [CandidatePresController::class, 'api_render'])->name('api_renderCanPres');
Route::post('/get-criteria-candidates-pres', [CandidatePresController::class, 'criteria'])->name('criteriaCanPres');
Route::post('/candidates-prestasi/import', [CandidatePresController::class, 'api_import'])->name('api_importCanPres');
Route::post('/candidates-prestasi/save', [CandidatePresController::class, 'api_save'])->name('api_saveCanPres');
Route::post('/candidates-prestasi/cancel', [CandidatePresController::class, 'api_cancel'])->name('api_cancelCanPres');

//Candidate Tes
Route::get('/candidates-tes', [CandidateTesController::class, 'api_render'])->name('api_renderCanTes');
Route::post('/get-criteria-candidates-tes', [CandidateTesController::class, 'criteria'])->name('criteriaCanTes');
Route::post('/candidates-tes/import', [CandidateTesController::class, 'api_import'])->name('api_importCanTes');
Route::post('/candidates-tes/save', [CandidateTesController::class, 'api_save'])->name('api_saveCanTes');
Route::post('/candidates-tes/cancel', [CandidateTesController::class, 'api_cancel'])->name('api_cancelCanTes');

//Candidate Mandiri
Route::get('/candidates-mandiri', [CandidateMandiriController::class, 'api_render'])->name('api_renderCanMan');
Route::post('/get-criteria-candidates-mandiri', [CandidateMandiriController::class, 'criteria'])->name('criteriaCanMan');
Route::post('/candidates-mandiri/import', [CandidateMandiriController::class, 'api_import'])->name('api_importCanMan');
Route::post('/candidates-mandiri/save', [CandidateMandiriController::class, 'api_save'])->name('api_saveCanMan');
Route::post('/candidates-mandiri/cancel', [CandidateMandiriController::class, 'api_cancel'])->name('api_cancelCanMan');


//Prodi Prestasi
Route::get('/prodi-prestasi', [ProdiPresController::class, 'api_render'])->name('api_renderProPres');
Route::post('/prodi-prestasi/insert', [ProdiPresController::class, 'api_insert'])->name('api_insertProPres');
Route::post('/prodi-prestasi/delete', [ProdiPresController::class, 'api_delete'])->name('api_deleteProPres');
Route::post('/prodi-prestasi/edit', [ProdiPresController::class, 'api_edit'])->name('api_editProPres');

//Prodi Tes
Route::get('/prodi-tes', [ProdiTesController::class, 'api_render'])->name('api_renderProTes');
Route::post('/prodi-tes/insert', [ProdiTesController::class, 'api_insert'])->name('api_insertProTes');
Route::post('/prodi-tes/delete', [ProdiTesController::class, 'api_delete'])->name('api_deleteProTes');
Route::post('/prodi-tes/edit', [ProdiTesController::class, 'api_edit'])->name('api_editProTes');

//Prodi Mandiri
Route::get('/prodi-mandiri', [ProdiMandiriController::class, 'api_render'])->name('api_renderProMand');
Route::post('/prodi-mandiri/insert', [ProdiMandiriController::class, 'api_insert'])->name('api_insertProMand');
Route::post('/prodi-mandiri/delete', [ProdiMandiriController::class, 'api_delete'])->name('api_deleteProMand');
Route::post('/prodi-mandiri/edit', [ProdiMandiriController::class, 'api_edit'])->name('api_editProMand');


//Binding Prodi Prestasi
Route::get('/bind-prodi-prestasi', [BindProdiPresController::class, 'render_api'])->name('api_renderBindProdiPres');
Route::post('/bind-prodi-prestasi/detail', [BindProdiPresController::class, 'detail'])->name('api_detailBindProdiPres');
Route::post('/bind-prodi-prestasi', [BindProdiPresController::class, 'api_binding'])->name('api_bindBindProdiPres');

//Binding Prodi Tes
Route::get('/bind-prodi-tes', [BindProdiTesController::class, 'render_api'])->name('api_renderBindProdiTes');
Route::post('/bind-prodi-tes/detail', [BindProdiTesController::class, 'detail'])->name('api_detailBindProdiTes');
Route::post('/bind-prodi-tes', [BindProdiTesController::class, 'api_binding'])->name('api_bindBindProdiTes');

//Binding Prodi Mandiri
Route::get('/bind-prodi-mandiri', [BindProdiMandController::class, 'render_api'])->name('api_renderBindProdiMand');
Route::post('/bind-prodi-mandiri/detail', [BindProdiMandController::class, 'detail'])->name('api_detailBindProdiMand');
Route::post('/bind-prodi-mandiri', [BindProdiMandController::class, 'api_binding'])->name('api_bindBindProdiMand');


//Preview Prestasi
Route::get('/preview-prestasi', [PreviewPresController::class, 'api_render'])->name('api_renderPreviewPres');

//Preview Tes
Route::get('/preview-tes', [PreviewTesController::class, 'api_render'])->name('api_renderPreviewTes');

//Preview Mandiri
Route::get('/preview-mandiri', [PreviewMandiriController::class, 'api_render'])->name('api_renderPreviewMand');


//Filter Prestasi
Route::get('/filter-pres', [FilterPresController::class, 'getTahun'])->name('api_tahunFilterPres');
Route::post('/filter-pres/pend', [FilterPresController::class, 'getPend'])->name('api_pendFilterPres');
Route::post('/filter-pres/kolom', [FilterPresController::class, 'getKolom'])->name('api_kolomFilterPres');
Route::post('/filter-pres/render', [FilterPresController::class, 'api_render'])->name('api_renderFilterPres');
Route::post('/filter-pres', [FilterPresController::class, 'api_save'])->name('saveFilterPres');
Route::post('/get-filter-pres', [FilterPresController::class, 'getFilter'])->name('getFilterPres');

//Filter Tes
Route::get('/filter-tes', [FilterTesController::class, 'getTahun'])->name('api_tahunFilterTes');
Route::post('/filter-tes/pend', [FilterTesController::class, 'getPend'])->name('api_pendFilterTes');
Route::post('/filter-tes/kolom', [FilterTesController::class, 'getKolom'])->name('api_kolomFilterTes');
Route::post('/filter-tes/render', [FilterTesController::class, 'api_render'])->name('api_renderFilterTes');
Route::post('/filter-tes', [FilterTesController::class, 'api_save'])->name('saveFilterTes');
Route::post('/get-filter-tes', [FilterTesController::class, 'getFilter'])->name('getFilterTes');


//Filter Mandiri
Route::get('/filter-mandiri', [FilterMandiriController::class, 'getTahun'])->name('api_tahunFilterMan');
Route::post('/filter-mandiri/pend', [FilterMandiriController::class, 'getPend'])->name('api_pendFilterMan');
Route::post('/filter-mandiri/kolom', [FilterMandiriController::class, 'getKolom'])->name('api_kolomFilterMan');
Route::post('/filter-mandiri/render', [FilterMandiriController::class, 'api_render'])->name('api_renderFilterMan');
Route::post('/filter-mandiri', [FilterMandiriController::class, 'api_save'])->name('saveFilterMan');
Route::post('/get-filter-mandiri', [FilterMandiriController::class, 'getFilter'])->name('getFilterMan');

//Pembobotan
Route::get('/pembobotan/tahun', [BobotController::class, 'getTahun'])->name('api_tahunBobot');
Route::post('/pembobotan/pend', [BobotController::class, 'getPend'])->name('api_pendBobot');
Route::post('/pembobotan/kolom', [BobotController::class, 'render_api'])->name('api_dataBobot');
Route::post('/pembobotan/nilai', [BobotController::class, 'getnilai'])->name('api_nilaiBobot');
Route::post('/pembobotan', [BobotController::class, 'api_insert'])->name('api_insertBobot');
Route::post('/pembobotan/delete', [BobotController::class, 'api_delete'])->name('api_deleteBobot');
Route::post('/pembobotan/edit', [BobotController::class, 'api_edit'])->name('api_editBobot');

//Finish
Route::get('/finish/tahun', [FinishController::class, 'getTahun'])->name('api_tahunFinish');
Route::post('/finish/pend', [FinishController::class, 'getPend'])->name('api_pendFinish');
Route::post('/finish/kolom', [FinishController::class, 'getKolom'])->name('api_kolomFinish');
Route::post('/finish/data', [FinishController::class, 'getData'])->name('api_dataFinish');
