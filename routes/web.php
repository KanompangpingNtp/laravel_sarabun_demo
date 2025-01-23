<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GetShowDataController;
use App\Http\Controllers\CreateDataController;

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

// Route::get('/', function () {
//     return view('pages.home');
// });

Route::get('/', [AuthController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/login', [AuthController::class, 'Login'])->name('Login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['checkAgencie1'])->group(function () {
    //รับหนังสือ
    Route::get('/sarabun', [GetShowDataController::class, 'getbookIndex'])->name('getbookIndex');
    Route::post('/getbook/create', [CreateDataController::class, 'getbookCreate'])->name('getbookCreate');

    //แฟ้มบนโต๊ะ
    Route::get('/BookFiles/index', [GetShowDataController::class, 'BookFiles'])->name('BookFiles');
});

Route::middleware(['checkAgencie2'])->group(function () {
});

Route::middleware(['checkAgencie3'])->group(function () {
});


