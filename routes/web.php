<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductGroupController;
use App\Http\Controllers\ArchiveDocumentController;

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

Route::get('/', function () {
    return view('auth.login');
});


Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);


// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    // ROUTE FOR CREATE CATEGORY
    Route::resource('category', CategoryController::class);
    Route::prefix('category')->name('category.')->group(function () {
        // Route::get('/create', [CategoryController::class, 'create'])->name('create');
        // Route::post('/store', [CategoryController::class, 'store'])->name('store');

        Route::prefix('get')->name('get.')->middleware(['json-response'])->group(function () {
            Route::post('category-datatable', [CategoryController::class, 'getCategoryDatatable'])->name('category-datatable');
        });
    });

    // ROUTE FOR CREATE PRODUCT GROUP
    Route::resource('productgroup', ProductGroupController::class);
    Route::prefix('productgroup')->name('productgroup.')->group(function () {
        // Route::get('/create', [ProductGroupController::class, 'create'])->name('create');
        // Route::post('/store', [ProductGroupController::class, 'store'])->name('store');

        Route::prefix('get')->name('get.')->middleware(['json-response'])->group(function () {
            Route::post('productgroup-datatable', [ProductGroupController::class, 'getProductGroupDatatable'])->name('productgroup-datatable');
        });
    });

    // ROUTE FOR ARCHIVE
    Route::prefix('archive')->name('archive.')->group(function () {
        Route::get('/', [ArchiveDocumentController::class, 'index'])->name('index');
        Route::get('/create', [ArchiveDocumentController::class, 'create'])->name('create');
        Route::post('/storeDocument', [ArchiveDocumentController::class, 'storeDocument'])->name('store.document');
        Route::delete('/destroyDocument/{document_id}', [ArchiveDocumentController::class, 'deleteDocument'])->name('destroy');
        Route::get('/edit/{document_id}', [ArchiveDocumentController::class, 'edit'])->name('edit');
        Route::post('/update', [ArchiveDocumentController::class, 'updateDocument'])->name('update');

        // Route::get('/{documentType_id}', [ArchiveDocumentController::class, 'showTypeDocument'])->name('show.document');

        // Route::get('/trash/{documentType_id}', [ArchiveDocumentController::class, 'trashDocument'])->name('trash.document');

        //ROUTE FOR JSON RESPONSE
        Route::prefix('get')->name('get.')->middleware(['json-response'])->group(function () {
            Route::get('product/{category_id}', [ArchiveDocumentController::class, 'getProductByCategoryId'])->name('product');
            Route::get('docnumber/{category_id}/{product_id}', [ArchiveDocumentController::class, 'generateDocNumber'])->name('docnumber');
        });
    });

    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/updateProfile', [SettingController::class, 'updateProfile'])->name('update');
    });

    // ROUTE FOR USER
    Route::resource('user', UserController::class);

    Route::prefix('user')->name('user.')->group(function () {

        //ROUTE FOR JSON RESPONSE
        Route::prefix('get')->name('get.')->middleware(['json-response'])->group(function () {
            Route::post('user-datatable', [UserController::class, 'getUserDatatable'])->name('user-datatable');
        });
    });

});

