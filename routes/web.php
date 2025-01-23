<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GetBookController;

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
    Route::get('/getbook/index', [GetBookController::class, 'getbookIndex'])->name('getbookIndex');
    Route::post('/getbook/create', [GetBookController::class, 'getbookCreate'])->name('getbookCreate');
});

Route::middleware(['checkAgencie2'])->group(function () {
    // Routes สำหรับ agencie_id 2
});

Route::middleware(['checkAgencie3'])->group(function () {
    // Routes สำหรับ agencie_id 3
});


