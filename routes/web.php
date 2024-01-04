<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
    return view('welcome');
});


Auth::routes([
    'login' => true,
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);



Route::get('/get-user', function(){
    if(Auth::check()){
        $user = Auth::user();

        return $user->load(['office']);
    }

    return [];
});



Route::post('/custom-login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
Route::get('/sample',[App\Http\Controllers\SampleController::class,'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



//ADDRESS
//Route::get('/load-provinces', [App\Http\Controllers\AddressController::class, 'loadProvinces']);
//Route::get('/load-cities', [App\Http\Controllers\AddressController::class, 'loadCities']);
//Route::get('/load-barangays', [App\Http\Controllers\AddressController::class, 'loadBarangays']);


//LIASON
Route::resource('/liaison-home', App\Http\Controllers\Liaison\LiaisonHomeController::class);
Route::get('/search-track-no', [App\Http\Controllers\Liaison\LiaisonHomeController::class, 'searchTrackNo']);

Route::resource('/documents', App\Http\Controllers\Liaison\LiaisonDocumentController::class);
Route::get('/get-documents', [App\Http\Controllers\Liaison\LiaisonDocumentController::class, 'getDocuments']);
Route::get('/get-document-routes', [App\Http\Controllers\Liaison\LiaisonDocumentController::class, 'getDocumentRoutes']);
Route::post('/document-forward/{docId}', [App\Http\Controllers\Liaison\LiaisonDocumentController::class, 'forwardDoc']);



//STAFF
Route::resource('/staff-home', App\Http\Controllers\Staff\StaffHomeController::class);

Route::resource('/staff-documents', App\Http\Controllers\Staff\StaffDocumentController::class);
Route::post('/documents-undo-forward-process', [App\Http\Controllers\Staff\StaffDocumentController::class, 'undoForwardReceive']);

Route::get('/count-forwarded-doc', [App\Http\Controllers\Staff\StaffDocumentController::class, 'countForwardedDoc']);

Route::get('/get-forwarded-documents', [App\Http\Controllers\Staff\ForwardedDocumentController::class, 'getForwardedDocument']);

Route::post('/document-receive/{id}', [App\Http\Controllers\Staff\ReceiveDocumentController::class, 'receiveDocument']);

Route::post('/document-process/{id}', [App\Http\Controllers\Staff\ProcessDocumentController::class, 'processDocument']);

Route::post('/document-forward/{id}/{docId}', [App\Http\Controllers\Staff\ForwardDocumentController::class, 'forwardDocument']);



/*     ADMINSITRATOR          */
Route::middleware(['auth', 'admin'])->group(function() {

    Route::resource('/admin-home', App\Http\Controllers\Administrator\AdminHomeController::class);

    Route::resource('/users', App\Http\Controllers\Administrator\UserController::class);
    Route::get('/get-users', [App\Http\Controllers\Administrator\UserController::class, 'getUsers']);
    Route::post('/reset-password/{id}', [App\Http\Controllers\Administrator\UserController::class, 'resetPassword']);


    Route::resource('/offices', App\Http\Controllers\Administrator\OfficeController::class);
    Route::get('/get-offices', [App\Http\Controllers\Administrator\OfficeController::class, 'getOffices']);
    Route::get('/get-offices-for-routes', [App\Http\Controllers\Administrator\OfficeController::class, 'getOfficesForRoutes']);

    Route::resource('/document-routes', App\Http\Controllers\Administrator\DocumentRouteController::class);
    Route::get('/get-admin-document-routes', [App\Http\Controllers\Administrator\DocumentRouteController::class, 'getDocumentRoutes']);

    Route::resource('/document-route-details', App\Http\Controllers\Administrator\DocumentRouteDetailController::class);

    Route::resource('/document-logs', App\Http\Controllers\Administrator\DocumentLogController::class);
    Route::get('/get-document-logs', [App\Http\Controllers\Administrator\DocumentLogController::class, 'getDocumentLogs']);
    

});


/*     ADMINSITRATOR          */

Route::get('/session', function(){
    return Session::all();
});


Route::get('/applogout', function(Request $req){
    \Auth::logout();
    $req->session()->invalidate();
    $req->session()->regenerateToken();
});