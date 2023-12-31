<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\SignUp;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Billing;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Tables;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Rtl;

use App\Http\Livewire\LaravelExamples\UserProfile;
use App\Http\Livewire\LaravelExamples\UserManagement;

use Illuminate\Http\Request;

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

Route::get('/', function() {
    return redirect('/login');
});

Route::get('/sign-up', SignUp::class)->name('sign-up');
Route::get('/login', Login::class)->name('login');

Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}',ResetPassword::class)->name('reset-password')->middleware('signed');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/billing', Billing::class)->name('billing');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/tables', Tables::class)->name('tables');
    Route::get('/static-sign-in', StaticSignIn::class)->name('sign-in');
    Route::get('/static-sign-up', StaticSignUp::class)->name('static-sign-up');
    Route::get('/rtl', Rtl::class)->name('rtl');
    Route::get('/laravel-user-profile', UserProfile::class)->name('user-profile');
    Route::get('/table-management/{label}', UserManagement::class)->name('/table-management/{label}');
    Route::post('table-store', [UserManagement::class, 'store'])->name('table-store');
    Route::post('table-update', [UserManagement::class, 'update'])->name('table-update');
    Route::post('delete-register', [UserManagement::class, 'delete'])->name('delete-register');
    Route::post('imgs-store', [UserManagement::class, 'saveImgs'])->name('imgs-store');
    Route::post('table-store-imgs', [UserManagement::class, 'store2'])->name('table-store-imgs');
    Route::post('update-store-imgs', [UserManagement::class, 'update2'])->name('update-store-imgs');
    Route::post('imgs-update', [UserManagement::class, 'saveImgs'])->name('imgs-update');
    Route::post('delete-img', [UserManagement::class, 'deleteImg'])->name('delete-img');
    Route::post('search-data', [UserManagement::class, 'searchData'])->name('search-data');
});

