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
// Route::get('home/fetch_data', [HomeController::class, 'fetch_data']);

//PDFs
//Documents
Route::get('documents/view-document-pdf/{transId}/{userId}',[DocumentsController::class, 'pdfViewDocument']);
Route::get('documents/generate-document-pdf/{transId}/{userId}',[DocumentsController::class, 'pdfSaveDocument']);

//Complaints
Route::get('complaints/show/view-complaint-pdf/{transId}/{userId}',[ComplaintsController::class, 'pdfViewComplaint']);
Route::get('complaints/show/generate-complaint-pdf/{transId}/{userId}',[ComplaintsController::class, 'pdfSaveComplaint']);
Route::get('complaints/show/view-settle-pdf/{transId}/{userId}',[ComplaintsController::class, 'pdfViewSettle']);
Route::get('complaints/show/generate-settle-pdf/{transId}/{userId}',[ComplaintsController::class, 'pdfSaveSettle']);
Route::get('complaints/show/view-escalate-pdf/{transId}/{userId}',[ComplaintsController::class, 'pdfViewEscalate']);
Route::get('complaints/show/generate-escalate-pdf/{transId}/{userId}',[ComplaintsController::class, 'pdfSaveEscalate']);

// Route::get('generate-pdf/{id}', [PDFController::class, 'generatePDF']);

//Processing of Document
Route::get('documents/process/{transId}/{userId}', [DocumentsController::class,'process']);
Route::get('documents/disapprove/{transId}', [DocumentsController::class,'disapproved']);
Route::get('documents/paid/{transId}', [DocumentsController::class,'paid']);

//Reason for Documents
Route::post('documents/process/{docId}/{transId}/{userId}', [DocumentsController::class,'reason']);
Route::get('documents/disapprove/{transId}/{userId}', [DocumentsController::class,'disapproved']);
Route::get('documents/paid/{transId}/{userId}', [DocumentsController::class,'paid']);

//Scan Documents
Route::get('documents/scan', [DocumentsController::class,'scan']);

//Cancelling of Document
Route::delete('documents/cancel/{transId}', [DocumentsController::class,'cancel']);

//Processing of Complaint
Route::get('complaints/show/settle/{transId}', [ComplaintsController::class,'settle']);
Route::get('complaints/show/escalate/{transId}', [ComplaintsController::class,'escalate']);
Route::get('complaints/show/dismiss/{transId}', [ComplaintsController::class,'dismiss']);

//Showing of a Complaint
Route::get('complaints/show/{transId}/{userId}', [ComplaintsController::class,'show']);

//Record Hearing
Route::post('complaints/show/hearing/{compId}/{transId}', [ComplaintsController::class,'recordHearing']);

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
