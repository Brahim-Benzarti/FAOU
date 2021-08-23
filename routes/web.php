<?php

use Illuminate\Support\Facades\Route;

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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
