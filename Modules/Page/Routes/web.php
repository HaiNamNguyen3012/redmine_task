<?php

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

Route::prefix('')->group(function () {
    Route::get('/', [\Modules\Page\Http\Controllers\HomeController::class, 'index'])->name('page.home.index');

    Route::get('/term', [\Modules\Page\Http\Controllers\HomeController::class, 'term'])->name('page.term.index');
    Route::get('/privacy-policy', [\Modules\Page\Http\Controllers\HomeController::class, 'policy'])->name('page.policy.index');
    Route::get('/company', [\Modules\Page\Http\Controllers\HomeController::class, 'company'])->name('page.company.index');
    Route::get('/contact', [\Modules\Page\Http\Controllers\HomeController::class, 'contact'])->name('page.contact.index');
    Route::post('/contact', [\Modules\Page\Http\Controllers\HomeController::class, 'postContact']);
    Route::get('/contact-success', [\Modules\Page\Http\Controllers\HomeController::class, 'contactSuccess'])->name('page.contact.success');
});

