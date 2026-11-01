<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartnershipController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// Public Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Program Details Page
Route::get('/programs/{slug}', [ProgramController::class, 'show'])->name('programs.show');

// Contact Submission Form
Route::post('/contact', [ContactController::class, 'submit'])
    ->middleware('throttle:10,1')
    ->name('contact.submit');

// Partnership Request Form
Route::post('/partnership', [PartnershipController::class, 'submit'])
    ->middleware('throttle:10,1')
    ->name('partnership.submit');

// Privacy Policy Page
Route::get('/privacy-policy', function () {
    return view('privacy');
})->name('privacy');

// Dynamic XML Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
