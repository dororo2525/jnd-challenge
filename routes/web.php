<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\ManageUserController;
use App\Http\Controllers\backend\ManageUrlController;


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

Route::get('/', [App\Http\Controllers\frontend\HomeController::class, 'index'])->name('home');
Route::get('/short/{link}', [App\Http\Controllers\frontend\HomeController::class, 'getShortenLink']);

Auth::routes();
Route::group(['middleware' => 'auth'],function () {
    Route::middleware(['admin'])->group(function () {
        Route::resource('manage-user', ManageUserController::class);
    });
    Route::resource('dashboard', DashboardController::class);
    Route::get('get-chart-data', [DashboardController::class, 'getClickbyCurrentDate'])->name('dashboard.get-chart-data');
    Route::post('post-chart-data', [DashboardController::class, 'getClickbyDate'])->name('dashboard.post-chart-data');
    Route::resource('manage-url', ManageUrlController::class);
    Route::post('manage-url/switch-status', [ManageUrlController::class, 'switchStatus'])->name('manage-url.switch-status');
});
