<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentsController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComplaintsController;
use App\Http\Controllers\BarangayOfficialsController;

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

Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('view-document-pdf/{id}',[DocumentsController::class, 'pdfViewDocument']);

Route::get('generate-document-pdf/{id}',[DocumentsController::class, 'pdfSaveDocument']);

Route::get('view-complaint-pdf/{id}',[ComplaintsController::class, 'pdfViewComplaint']);

Route::get('generate-complaint-pdf/{id}',[ComplaintsController::class, 'pdfSaveComplaint']);

// Route::get('generate-pdf/{id}', [PDFController::class, 'generatePDF']);

Route::group(['middleware' => ['auth']], function() {
    Route::resource('users', UserController::class);
    Route::resource('profiles', ProfileController::class);
    Route::resource('documents', DocumentsController::class);
    Route::resource('complaints', ComplaintsController::class);
    Route::resource('officials', BarangayOfficialsController::class);
});