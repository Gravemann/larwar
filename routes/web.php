<?php

use App\Http\Controllers\brandscontr;
use App\Http\Controllers\orderscontr;
use App\Http\Controllers\userscontr;
use App\Jobs\EmailVerificationResendJob;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('brands', [brandscontr::class, 'index'])->name('brands');
    Route::post('add-update-book', [brandscontr::class, 'store']);
    Route::post('edit-book', [brandscontr::class, 'edit']);
    Route::post('delete-book', [brandscontr::class, 'destroy']);

    Route::get('orders', [orderscontr::class, 'index'])->name('orders');
    Route::post('add-update-order', [orderscontr::class, 'store']);
    Route::post('edit-order', [orderscontr::class, 'edit']);
    Route::post('delete-order', [orderscontr::class, 'destroy']);
    Route::post('confirm-order', [orderscontr::class, 'confirm']);
    Route::post('unconfirm-order', [orderscontr::class, 'unconfirm']);


    Route::get('/test', function () {
        return view('test');
    })->name('test');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');


    Route::get('/products', 'App\Http\Controllers\productscontr@list')->name(
        'products'
    );
    Route::post('/addpr', 'App\Http\Controllers\productscontr@add')->name(
        'addpr'
    );
    Route::get('/qdeletepr/{id}', 'App\Http\Controllers\productscontr@qdelete')
        ->name('qdeletepr');
    Route::get('/cdeletepr/{id}', 'App\Http\Controllers\productscontr@condel')
        ->name('cdeletepr');
    Route::get('/editpr/{id}', 'App\Http\Controllers\productscontr@edit')->name(
        'editpr'
    );
    Route::post('/updatepr', 'App\Http\Controllers\productscontr@update')->name(
        'updatepr'
    );
    Route::get('/cancelpr', 'App\Http\Controllers\productscontr@cancel')->name(
        'cancelpr'
    );

    Route::get('/clients', 'App\Http\Controllers\clientscontr@list')->name(
        'clients'
    );
    Route::post('/addcl', 'App\Http\Controllers\clientscontr@add')->name(
        'addcl'
    );
    Route::get('/qdeletecl/{id}', 'App\Http\Controllers\clientscontr@qdelete')
        ->name('qdeletecl');
    Route::get('/cdeletecl/{id}', 'App\Http\Controllers\clientscontr@condel')
        ->name('cdeletecl');
    Route::get('/editcl/{id}', 'App\Http\Controllers\clientscontr@edit')->name(
        'editcl'
    );
    Route::post('/updatecl', 'App\Http\Controllers\clientscontr@update')->name(
        'updatecl'
    );
    Route::get('/cancelcl', 'App\Http\Controllers\clientscontr@cancel')->name(
        'cancelcl'
    );

    Route::get('/orders', 'App\Http\Controllers\orderscontr@list')->name(
        'orders'
    );
    Route::post('/addor', 'App\Http\Controllers\orderscontr@add')->name(
        'addor'
    );
    Route::get('/qdeleteor/{id}', 'App\Http\Controllers\orderscontr@qdelete')
        ->name('qdeleteor');
    Route::get('/cdeleteor/{id}', 'App\Http\Controllers\orderscontr@condel')
        ->name('cdeleteor');
    Route::get('/editor/{id}', 'App\Http\Controllers\orderscontr@edit')->name(
        'editor'
    );
    Route::post('/updateor', 'App\Http\Controllers\orderscontr@update')->name(
        'updateor'
    );
    Route::get('/cancelor', 'App\Http\Controllers\orderscontr@cancel')->name(
        'cancelor'
    );
    Route::get('/confirm/{id}', 'App\Http\Controllers\orderscontr@confirm')
        ->name('confirm');
    Route::get('/unconfirm/{id}', 'App\Http\Controllers\orderscontr@unconfirm')
        ->name('unconfirm');
});


Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('auth.index');
    })->name('index');

    Route::post('/register', 'App\Http\Controllers\userscontr@register')->name(
        'register'
    );

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/loginuser', 'App\Http\Controllers\userscontr@login')
        ->name('loginuser');

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post(
        '/forgot-password',
        [userscontr::class, 'password_reset_email']
    )->name('password.email');

    Route::get('/reset-password/{token}', function ($token, Request $request) {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    })->name('password.reset');

    Route::post(
        '/reset-password',
        [userscontr::class, 'password_update']
    )->name('password.update');
});


Route::get('/logout', 'App\Http\Controllers\userscontr@logout')->middleware(
    'auth'
)->name('logout');

Route::get('/email/verify', function () {
    return view('auth.verify-email', ['email' => auth()->user()->email]);
})->middleware('auth')->name('verification.notice');

Route::get(
    '/email/verify/{id}/{hash}',
    function (EmailVerificationRequest $request) {
        $request->fulfill();

        return view('auth.verified', ['email' => auth()->user()->email]);
    }
)->middleware(['auth', 'signed',])->name('verification.verify');

Route::post(
    '/email/verification-notification',
    function (Request $request) {
        EmailVerificationResendJob::dispatch($request->user());

        return back()->with('message', 'Verification link sent!');
    }
)->middleware(['auth', 'throttle:6,1'])->name('verification.send');
