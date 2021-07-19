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
use App\Http\Controllers\BlottersController;
use App\Http\Controllers\BarangayOfficialsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServicesController;

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

//PDFs
//Documents
Route::get('view-document-pdf/{transId}/{userId}',[DocumentsController::class, 'pdfViewDocument']);
Route::get('generate-document-pdf/{transId}/{userId}',[DocumentsController::class, 'pdfSaveDocument']);
//Complaints
Route::get('view-complaint-pdf/{transId}/{userId}',[ComplaintsController::class, 'pdfViewComplaint']);
Route::get('generate-complaint-pdf/{transId}/{userId}',[ComplaintsController::class, 'pdfSaveComplaint']);
Route::get('view-settle-pdf/{transId}/{userId}',[ComplaintsController::class, 'pdfViewSettle']);
Route::get('generate-settle-pdf/{transId}/{userId}',[ComplaintsController::class, 'pdfSaveSettle']);
Route::get('view-escalate-pdf/{transId}/{userId}',[ComplaintsController::class, 'pdfViewEscalate']);
Route::get('generate-escalate-pdf/{transId}/{userId}',[ComplaintsController::class, 'pdfSaveEscalate']);

// Route::get('generate-pdf/{id}', [PDFController::class, 'generatePDF']);

//Processing of Document
Route::get('documents/process/{transId}/{userId}', [DocumentsController::class,'process']);
Route::get('documents/paid/{transId}/{userId}', [DocumentsController::class,'paid']);

//Processing of Complaint
Route::get('complaints/settle/{transId}/{userId}', [ComplaintsController::class,'settle']);
Route::get('complaints/escalate/{transId}/{userId}', [ComplaintsController::class,'escalate']);

//Processing of Blotters
Route::get('blotters/note/{transId}/{userId}', [BlottersController::class,'noted']);

Route::group(['middleware' => ['auth']], function() {
    Route::resource('users', UserController::class);
    Route::resource('profiles', ProfileController::class);
    Route::resource('documents', DocumentsController::class);
    Route::resource('complaints', ComplaintsController::class);
    Route::resource('blotters', BlottersController::class);
    Route::resource('officials', BarangayOfficialsController::class);
    Route::resource('reports', ReportController::class);
    Route::resource('services', ServicesController::class);
});
