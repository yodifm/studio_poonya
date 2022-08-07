<?php

use App\Http\Controllers\webcontroller;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Test;

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


Route::get('/',[webcontroller::class,'payment']);

Route::get('/payment', [webcontroller::class,'payment']);
Route::post('/payment',[webcontroller::class,'payment_post']);

Route::get('/dashboard',[webcontroller::class,'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/generate',[webcontroller::class,'generate'])->name('generate');

Route::get('/login',[LoginController::class,'loginpage'])->name('login');
Route::post('/postlogin',[LoginController::class,'postlogin'])->name('postlogin');

Route::get('/logout',[LoginController::class,'logout'])->name('logout');

Route::get('/generateCode',[webController::class,'generateCode'])->name('generateCode');
Route::get('/generatePayment',[webController::class,'generatePayment'])->name('generatePayment');

Route::get('/redeemCode',[webController::class,'redeemCode'])->name('redeemCode');


Route::get('/Test', function () {
    // $answer = shell_exec("C:\\WINDOWS\\system32\\notepad.exe");
    $answer = shell_exec("C:\\Program Files\\dslrBooth\\dslrBooth.exe");
    echo $answer;

});


