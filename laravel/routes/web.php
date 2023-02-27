<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PlacesController;
use App\Http\Controllers\PlaceCrudController;
use App\Http\Controllers\ReviewController;



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
// ...
Route::get('mail/test', [MailController::class, 'test']);
// or
// Route::get('mail/test', 'App\Http\Controllers\MailController@test');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function (Request $request) {
    $message = 'Loading welcome page';
    Log::info($message);
    $request->session()->flash('info', $message);
    return view('auth/login');
});

Route::resource('files', FileController::class)
    ->middleware(['auth']);
Route::resource('places', PlacesController::class)
    ->middleware(['auth']);

Route::resource('places.reviews', ReviewController::class);

Route::get('/language/{locale}', [App\Http\Controllers\LanguageController::class, 'language']);

Route::post('/places/{place}/favourites', [App\Http\Controllers\PlacesController::class, 'favourite'])->name('places.favourite');
Route::delete('/places/{place}/favourites', [App\Http\Controllers\PlacesController::class, 'unfavourite'])->name('places.unfavourite');

Route::get('/aboutme', function () {
    return view('aboutme');
 });

 Route::get('/contact-page', function () {
    return view('contact-page');
 });
 