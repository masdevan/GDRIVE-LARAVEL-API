<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleDriveController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', [GoogleDriveController::class, 'index'])->name('upload.form');
Route::post('/upload', [GoogleDriveController::class, 'upload'])->name('upload.file');
Route::post('/google-drive/create-folder', [GoogleDriveController::class, 'createFolder'])->name('google-drive.create-folder');