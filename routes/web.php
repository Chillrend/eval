<?php

use App\Http\Controllers\BindProdiTesController;
use App\Http\Controllers\BindProdiMandController;
use App\Http\Controllers\BindProdiPresController;
use App\Http\Controllers\BobotController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdiTesController;
use App\Http\Controllers\ProdiPresController;
use App\Http\Controllers\ProdiPresController1;
use App\Http\Controllers\ProdiMandiriController;
use App\Http\Controllers\PreviewTesController;
use App\Http\Controllers\PreviewPresController;
use App\Http\Controllers\PreviewMandiriController;
use App\Http\Controllers\CandidateTesController;
use App\Http\Controllers\CandidatePresController;
use App\Http\Controllers\CandidateMandiriController;
use App\Http\Controllers\FilterMandiriController;
use App\Http\Controllers\FilterPresController;
use App\Http\Controllers\FilterTesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');

// Auth
Route::get('/login', function () {
    return view('halaman.login');
})->name('login');

Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout');

Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('halaman.dashboard', ['type_menu' => 'dashboard']);
    })->name('dashboard');



    // Prestasi
    Route::get('/candidates-prestasi', [CandidatePresController::class, 'render']);
    Route::post('/candidates-prestasi', [CandidatePresController::class, 'import']);

    Route::post('/cancelCanPres', [CandidatePresController::class, 'cancelprestasi'])->name('cancelCanPres');
    Route::post('/saveCanPres', [CandidatePresController::class, 'saveprestasi'])->name('saveCanPres');


    // Route::get('/prodi-prestasi', [ProdiPresController::class,'render']);
    // Route::post('/prodi-prestasi', [ProdiPresController::class,'import']);
    Route::get('/prodi-prestasi', [ProdiPresController::class, 'render']);
    Route::post('/prodi-prestasi', [ProdiPresController::class, 'insert'])->name('addProdiPres');
    // Route::post('/prodi-tes', [ProdiPresController::class,'import']);
    Route::post('/delete-prodi-prestasi/{id}', [ProdiPresController::class, 'delete'])->name('delProdiPres');
    Route::post('/edit-prodi-prestasi/{id}', [ProdiPresController::class, 'edit'])->name('editProdiPres');
    Route::post('/cancel-prodi-prestasi/{id}', [ProdiPresController::class, 'cancel'])->name('cancelProdiPres');

    Route::get('/bind-prodi-prestasi', [BindProdiPresController::class, 'render'])->name('renderBindProdiPrestasi');

    Route::post('cancelProPres', [ProdiPresController::class, 'cancel'])->name('cancelProPres');
    Route::post('saveProPres', [ProdiPresController::class, 'save'])->name('saveProPres');

    Route::get('/prodi-prestasi-test', [ProdiPresController1::class, 'render']);
    Route::post('/prodi-prestasi-test', [ProdiPresController1::class, 'import']);

    Route::post('/cancelProPres', [ProdiPresController::class, 'cancel'])->name('cancelProPres');
    Route::post('/saveProPres', [ProdiPresController::class, 'save'])->name('saveProPres');

    Route::get('/preview-prestasi', [PreviewPresController::class, 'render'])->name('previewPres');

    Route::get('/filter-prestasi', [FilterPresController::class, 'render'])->name('renderFilterPres');


    //Tes
    Route::get('/candidates-tes', [CandidateTesController::class, 'render']);
    Route::post('/candidates-tes', [CandidateTesController::class, 'import']);

    Route::post('cancelCanTes', [CandidateTesController::class, 'cancel'])->name('cancelCanTes');
    Route::post('saveCanTes', [CandidateTesController::class, 'save'])->name('saveCanTes');

    Route::get('/prodi-tes', [ProdiTesController::class, 'render'])->name('renderProdiTes');
    Route::post('/prodi-tes', [ProdiTesController::class, 'insert'])->name('addProdiTes');
    Route::post('/delete-prodi-tes/{id}', [ProdiTesController::class, 'delete'])->name('delProdiTes');
    Route::post('/edit-prodi-tes/{id}', [ProdiTesController::class, 'edit'])->name('editProdiTes');

    Route::get('/bind-prodi-tes', [BindProdiTesController::class, 'render'])->name('renderBindProdiTes');

    Route::post('cancelProTes', [ProdiTesController::class, 'cancel'])->name('cancelProTes');
    Route::post('saveProTes', [ProdiTesController::class, 'save'])->name('saveProTes');

    Route::get('/preview-tes', [PreviewTesController::class, 'render'])->name('previewTes');

    Route::get('/filter-tes', [FilterTesController::class, 'render'])->name('renderFilterTes');



    //Mandiri
    Route::get('/candidates-mandiri', [CandidateMandiriController::class, 'render']);
    Route::post('/candidates-mandiri', [CandidateMandiriController::class, 'import']);

    Route::post('cancelmandiri', [CandidateMandiriController::class, 'cancelmandiri'])->name('cancelmandiri');
    Route::post('savemandiri', [CandidateMandiriController::class, 'savemandiri'])->name('savemandiri');

    // Route::get('/prodi-mandiri', [ProdiMandiriController::class,'render']);
    // Route::post('/prodi-mandiri', [ProdiMandiriController::class,'import']);

    Route::get('/prodi-mandiri', [ProdiMandiriController::class, 'render']);
    Route::post('/prodi-mandiri', [ProdiMandiriController::class, 'insert'])->name('addProdiMand');
    // Route::post('/prodi-mandiri', [ProdiMandiriController::class,'import']);
    Route::post('/delete-prodi-mandiri/{id}', [ProdiMandiriController::class, 'delete'])->name('delProdiMand');
    Route::post('/edit-prodi-mandiri/{id}', [ProdiMandiriController::class, 'edit'])->name('editProdiMand');
    Route::post('/cancel-prodi-mandiri/{id}', [ProdiMandiriController::class, 'cancel'])->name('cancelProdiMand');

    Route::get('/bind-prodi-mandiri', [BindProdiMandController::class, 'render'])->name('renderBindProdiMand');

    Route::post('cancelProMan', [ProdiMandiriController::class, 'cancelprodimandiri'])->name('cancelProMan');
    Route::post('saveProMan', [ProdiMandiriController::class, 'saveprodimandiri'])->name('saveProMan');


    Route::get('/preview-mandiri', [PreviewMandiriController::class, 'render'])->name('previewMan');

    Route::get('/filter-mandiri', [FilterMandiriController::class, 'render'])->name('renderFilterMan');


    //PEMBOBOTAN
    Route::get('/pembobotan', [BobotController::class, 'render'])->name('renderBobot');
});


/*
|--------------------------------------------------------------------------
| INI TEMPLATE ROUTES
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Route::redirect('/', '/dashboard-general-dashboard');

// Dashboard
Route::get('/dashboard-general-dashboard', function () {
    return view('pages.dashboard-general-dashboard', ['type_menu' => 'dashboard']);
});
Route::get('/dashboard-ecommerce-dashboard', function () {
    return view('pages.dashboard-ecommerce-dashboard', ['type_menu' => 'dashboard']);
});


// Layout
Route::get('/layout-default-layout', function () {
    return view('pages.layout-default-layout', ['type_menu' => 'layout']);
});

// Blank Page
Route::get('/blank-page', function () {
    return view('pages.blank-page', ['type_menu' => '']);
});

// Bootstrap
Route::get('/bootstrap-alert', function () {
    return view('pages.bootstrap-alert', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-badge', function () {
    return view('pages.bootstrap-badge', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-breadcrumb', function () {
    return view('pages.bootstrap-breadcrumb', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-buttons', function () {
    return view('pages.bootstrap-buttons', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-card', function () {
    return view('pages.bootstrap-card', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-carousel', function () {
    return view('pages.bootstrap-carousel', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-collapse', function () {
    return view('pages.bootstrap-collapse', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-dropdown', function () {
    return view('pages.bootstrap-dropdown', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-form', function () {
    return view('pages.bootstrap-form', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-list-group', function () {
    return view('pages.bootstrap-list-group', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-media-object', function () {
    return view('pages.bootstrap-media-object', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-modal', function () {
    return view('pages.bootstrap-modal', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-nav', function () {
    return view('pages.bootstrap-nav', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-navbar', function () {
    return view('pages.bootstrap-navbar', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-pagination', function () {
    return view('pages.bootstrap-pagination', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-popover', function () {
    return view('pages.bootstrap-popover', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-progress', function () {
    return view('pages.bootstrap-progress', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-table', function () {
    return view('pages.bootstrap-table', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-tooltip', function () {
    return view('pages.bootstrap-tooltip', ['type_menu' => 'bootstrap']);
});
Route::get('/bootstrap-typography', function () {
    return view('pages.bootstrap-typography', ['type_menu' => 'bootstrap']);
});


// components
Route::get('/components-article', function () {
    return view('pages.components-article', ['type_menu' => 'components']);
});
Route::get('/components-avatar', function () {
    return view('pages.components-avatar', ['type_menu' => 'components']);
});
Route::get('/components-chat-box', function () {
    return view('pages.components-chat-box', ['type_menu' => 'components']);
});
Route::get('/components-empty-state', function () {
    return view('pages.components-empty-state', ['type_menu' => 'components']);
});
Route::get('/components-gallery', function () {
    return view('pages.components-gallery', ['type_menu' => 'components']);
});
Route::get('/components-hero', function () {
    return view('pages.components-hero', ['type_menu' => 'components']);
});
Route::get('/components-multiple-upload', function () {
    return view('pages.components-multiple-upload', ['type_menu' => 'components']);
});
Route::get('/components-pricing', function () {
    return view('pages.components-pricing', ['type_menu' => 'components']);
});
Route::get('/components-statistic', function () {
    return view('pages.components-statistic', ['type_menu' => 'components']);
});
Route::get('/components-tab', function () {
    return view('pages.components-tab', ['type_menu' => 'components']);
});
Route::get('/components-table', function () {
    return view('pages.components-table', ['type_menu' => 'components']);
});
Route::get('/components-user', function () {
    return view('pages.components-user', ['type_menu' => 'components']);
});
Route::get('/components-wizard', function () {
    return view('pages.components-wizard', ['type_menu' => 'components']);
});

// forms
Route::get('/forms-advanced-form', function () {
    return view('pages.forms-advanced-form', ['type_menu' => 'forms']);
});
Route::get('/forms-editor', function () {
    return view('pages.forms-editor', ['type_menu' => 'forms']);
});
Route::get('/forms-validation', function () {
    return view('pages.forms-validation', ['type_menu' => 'forms']);
});

// google maps
// belum tersedia

// modules
Route::get('/modules-calendar', function () {
    return view('pages.modules-calendar', ['type_menu' => 'modules']);
});
Route::get('/modules-chartjs', function () {
    return view('pages.modules-chartjs', ['type_menu' => 'modules']);
});
Route::get('/modules-datatables', function () {
    return view('pages.modules-datatables', ['type_menu' => 'modules']);
});
Route::get('/modules-flag', function () {
    return view('pages.modules-flag', ['type_menu' => 'modules']);
});
Route::get('/modules-font-awesome', function () {
    return view('pages.modules-font-awesome', ['type_menu' => 'modules']);
});
Route::get('/modules-ion-icons', function () {
    return view('pages.modules-ion-icons', ['type_menu' => 'modules']);
});
Route::get('/modules-owl-carousel', function () {
    return view('pages.modules-owl-carousel', ['type_menu' => 'modules']);
});
Route::get('/modules-sparkline', function () {
    return view('pages.modules-sparkline', ['type_menu' => 'modules']);
});
Route::get('/modules-sweet-alert', function () {
    return view('pages.modules-sweet-alert', ['type_menu' => 'modules']);
});
Route::get('/modules-toastr', function () {
    return view('pages.modules-toastr', ['type_menu' => 'modules']);
});
Route::get('/modules-vector-map', function () {
    return view('pages.modules-vector-map', ['type_menu' => 'modules']);
});
Route::get('/modules-weather-icon', function () {
    return view('pages.modules-weather-icon', ['type_menu' => 'modules']);
});

// auth
Route::get('/auth-forgot-password', function () {
    return view('pages.auth-forgot-password', ['type_menu' => 'auth']);
});
Route::get('/auth-login', function () {
    return view('pages.auth-login', ['type_menu' => 'auth']);
});
Route::get('/auth-login2', function () {
    return view('pages.auth-login2', ['type_menu' => 'auth']);
});
Route::get('/auth-register', function () {
    return view('pages.auth-register', ['type_menu' => 'auth']);
});
Route::get('/auth-reset-password', function () {
    return view('pages.auth-reset-password', ['type_menu' => 'auth']);
});

// error
Route::get('/error-403', function () {
    return view('pages.error-403', ['type_menu' => 'error']);
});
Route::get('/error-404', function () {
    return view('pages.error-404', ['type_menu' => 'error']);
});
Route::get('/error-500', function () {
    return view('pages.error-500', ['type_menu' => 'error']);
});
Route::get('/error-503', function () {
    return view('pages.error-503', ['type_menu' => 'error']);
});

// features
Route::get('/features-activities', function () {
    return view('pages.features-activities', ['type_menu' => 'features']);
});
Route::get('/features-post-create', function () {
    return view('pages.features-post-create', ['type_menu' => 'features']);
});
Route::get('/features-post', function () {
    return view('pages.features-post', ['type_menu' => 'features']);
});
Route::get('/features-profile', function () {
    return view('pages.features-profile', ['type_menu' => 'features']);
});
Route::get('/features-settings', function () {
    return view('pages.features-settings', ['type_menu' => 'features']);
});
Route::get('/features-setting-detail', function () {
    return view('pages.features-setting-detail', ['type_menu' => 'features']);
});
Route::get('/features-tickets', function () {
    return view('pages.features-tickets', ['type_menu' => 'features']);
});

// utilities
Route::get('/utilities-contact', function () {
    return view('pages.utilities-contact', ['type_menu' => 'utilities']);
});
Route::get('/utilities-invoice', function () {
    return view('pages.utilities-invoice', ['type_menu' => 'utilities']);
});
Route::get('/utilities-subscribe', function () {
    return view('pages.utilities-subscribe', ['type_menu' => 'utilities']);
});

// credits
Route::get('/credits', function () {
    return view('pages.credits', ['type_menu' => '']);
});
