<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
np| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//============================ mail start =============================================
Route::get('/newMail', function(){
    return view("newMail");
} );

Route::post('/newMail', [App\Http\Controllers\UserController::class,"newMail"])->name('user.newMail');


Route::get('/m', function(){
    return view("mail");
});
//========================== mail end ==================================================

Route::get('/', function(){
    return view("welcome");
} );



//============== ajax crud start =================================================================
Route::get('/ajax', [App\Http\Controllers\UserController::class,"ajax"])->name('user.ajax');
Route::delete('/ajaxDel/{user}', [App\Http\Controllers\UserController::class,"ajaxDel"])->name('user.ajaxDel');
Route::post('/save', [App\Http\Controllers\UserController::class,"save"])->name('user.save');
Route::post('/ajaxUpdate', [App\Http\Controllers\UserController::class,"ajaxUpdate"])->name('user.ajaxUpdate');

//============== ajax crud end =====================================================================



Route::get('pdfview',[App\Http\Controllers\UserController::class,"pdfview"])->name("user.pdfview");  

Route::get('/user/{user}/image', [App\Http\Controllers\UserController::class,"image"])->name('user.image');
Route::post('/upload/{user}', [App\Http\Controllers\UserController::class,"upload"])->name('user.upload');
Route::resource('/user', App\Http\Controllers\UserController::class);

//----------------------------Excel methods start---------------------------------
Route::get('importExportView', [App\Http\Controllers\UserController::class, 'importExportView'])->name('importExportView');
Route::get('export', [App\Http\Controllers\UserController::class, 'export'])->name('export');
Route::post('import', [App\Http\Controllers\UserController::class, 'import'])->name('import');
//----------------------------Excel methods end---------------------------------


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


