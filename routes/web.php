<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmailController;

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
    return view('welcome',["email"=>env('MAIN_CONTACT'), "name"=>env('MAIN_CONTACT_IDENTIFIER')]);
});

Route::middleware('auth')->group(function (){
    Route::get("Interviews", [App\Http\Controllers\interviews::class, "index"])->name("InterviewsHome");
    Route::get("Decide_Interviews", [App\Http\Controllers\interviews::class, "interviews"])->name("Interviews");
    Route::get("Acceptance", [App\Http\Controllers\interviews::class, "acceptance"])->name("AcceptanceHome");
    Route::get("Add_Applications", [App\Http\Controllers\interviews::class, "add"])->name("AddApplications");
    Route::post("Add_Applications", [App\Http\Controllers\interviews::class, "add"])->name("AddApplications");
    Route::get("View_Application/{index?}", [App\Http\Controllers\interviews::class, "viewone"])->name("ViewApplication");
    Route::post("View_Application/{index?}", [App\Http\Controllers\interviews::class, "viewone"]);
    Route::prefix("ViewApplication")->group(function (){
        Route::get('/', [App\Http\Controllers\interviews::class, "view"])->name("viewdefault");
        Route::post('/pending/{page?}', [App\Http\Controllers\interviews::class, "pending"])->name("viewpending");
        Route::post('/seen/{page?}', [App\Http\Controllers\interviews::class, "seen"])->name("viewseen");
    });
    Route::get('/Download_Result' ,[App\Http\Controllers\interviews::class, "download"])->name("backupdownload");
    Route::prefix('email')->group(function(){
        Route::get('/interview/{id?}', [App\Http\Controllers\interviews::class, "interview"])->name("interviewemail");
        Route::post('/interview', [App\Http\Controllers\interviews::class, "interview"]);
        Route::get('/rejection/{id?}', [App\Http\Controllers\interviews::class, "reject"])->name("rejectemail");
        Route::get('/accept/{id?}', [EmailController::class, "acceptmail"])->name("acceptemail");
        Route::post('/accept', [EmailController::class, "acceptmail"]);
    });
    Route::post('peoplelist', [App\Http\Controllers\interviews::class, "people"])->name("people");
    Route::post('acceptedpeoplelist', [App\Http\Controllers\interviews::class, "acceptedpeople"]);
    Route::post('mail/{id?}', [App\Http\Controllers\interviews::class, "mail"]);
    Route::get('mail/{id?}', [App\Http\Controllers\interviews::class, "mail"]);

    Route::prefix('home')->group(function(){
        Route::get('/Refer', [EmailController::class, 'refer'])->name('refer');
        Route::get('/EditEmail', [EmailController::class, "index"])->name('editmail');
        Route::post('/EditEmail', [EmailController::class, 'index'])->name('editingmail');
    });

    Route::post('intern/{id}', [App\Http\Controllers\interviews::class, "intern"]);
    Route::post('decline/{id}', [App\Http\Controllers\interviews::class, "decline"]);
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::match(['get','post'], '/Update_Profile', [HomeController::class, 'edit'])->name('profileEdit');
Route::post('/newseason', [HomeController::class ,'newseason'])->name("newSeason");
