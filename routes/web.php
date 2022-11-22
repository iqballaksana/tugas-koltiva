<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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

//login
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login/postLogin', [LoginController::class, 'postLogin'])->name('postLogin');
Route::post('/login/logOut', [LoginController::class, 'logOut'])->name('logout');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'daftarBaru'])->name('daftarBaru');

//home
Route::get('/home', [HomeController::class, 'index'])->name('home');

//user
//pertanyaan
Route::get('/user/{id}', [UserController::class, 'show'])->name('user_show');
Route::get('/userform', [UserController::class, 'form'])->name('user_form');
Route::get('/usercreate', [UserController::class, 'create'])->name('user_create');
Route::post('/postUser', [UserController::class, 'store'])->name('postUser');
Route::put('/postUser', [UserController::class, 'store'])->name('postUser');
Route::get('/user', [UserController::class, 'index'])->name('user_admin');
Route::delete('/user/{id}', [UserController::class, 'delete'])->name('delete_user');


