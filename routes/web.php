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
    return view('login');
});


Auth::routes([
    'login' => false,
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);



Route::get('/get-user', function(){
    if(Auth::check()){
        return Auth::user();
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
Route::resource('/liason-home', App\Http\Controllers\Liason\LiasonHomeController::class);
Route::get('/search-track-no', [App\Http\Controllers\Liason\LiasonHomeController::class, 'searchTrackNo']);

Route::resource('/documents', App\Http\Controllers\Liason\LiasonDocumentController::class);
Route::get('/get-documents', [App\Http\Controllers\Liason\LiasonDocumentController::class, 'getDocuments']);
Route::get('/get-document-routes', [App\Http\Controllers\Liason\LiasonDocumentController::class, 'getDocumentRoutes']);
Route::post('/document-forward/{docId}', [App\Http\Controllers\Liason\LiasonDocumentController::class, 'forwardDoc']);



//STAFF
Route::resource('/staff-home', App\Http\Controllers\Staff\StaffHomeController::class);

Route::resource('/staff-documents', App\Http\Controllers\Staff\StaffDocumentController::class);


Route::get('/get-forwarded-documents', [App\Http\Controllers\Staff\ForwardedDocumentController::class, 'getForwardedDocument']);

Route::post('/document-receive/{id}', [App\Http\Controllers\Staff\ReceiveDocumentController::class, 'receiveDocument']);

Route::post('/document-process/{id}', [App\Http\Controllers\Staff\ProcessDocumentController::class, 'processDocument']);

Route::post('/document-forward/{id}/{docId}', [App\Http\Controllers\Staff\ForwardDocumentController::class, 'forwardDocument']);



/*     ADMINSITRATOR          */
Route::resource('/admin-home', App\Http\Controllers\Administrator\AdminHomeController::class);

Route::resource('/users', App\Http\Controllers\Administrator\UserController::class);
Route::get('/get-users', [App\Http\Controllers\Administrator\UserController::class, 'getUsers']);


Route::resource('/offices', App\Http\Controllers\Administrator\OfficeController::class);
Route::get('/get-offices', [App\Http\Controllers\Administrator\OfficeController::class, 'getOffices']);
Route::get('/get-offices-for-routes', [App\Http\Controllers\Administrator\OfficeController::class, 'getOfficesForRoutes']);


Route::middleware(['auth', 'admin'])->group(function() {

    Route::resource('/document-routes', App\Http\Controllers\Administrator\DocumentRouteController::class);
    Route::get('/get-admin-document-routes', [App\Http\Controllers\Administrator\DocumentRouteController::class, 'getDocumentRoutes']);

    Route::resource('/document-route-details', App\Http\Controllers\Administrator\DocumentRouteDetailController::class);

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
