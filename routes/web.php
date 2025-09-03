<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ImageHomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProjectMediaController;
use App\Http\Controllers\ReviewRatingController;
use App\Http\Controllers\ContactSubmissionController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/project-media/{projectSlug}/{type}', [ProjectMediaController::class, 'getMedia'])->name('project.media');

Route::get('/news', [BlogController::class, 'index'])->name('news.index');
Route::get('/news/category/{slug}', [BlogController::class, 'category'])->name('news.category');
Route::get('/news/{slug}', [BlogController::class, 'show'])->name('news.show');
Route::post('/news/filter', [BlogController::class, 'filter'])->name('news.filter');

// Contact submissions
Route::post('/contact/submit', [ContactSubmissionController::class, 'store'])->name('contact.submit');

// Language switching
Route::get('/language/{locale}', [App\Http\Controllers\LanguageController::class, 'switchLanguage'])->name('language.switch');

// Image Homes for AJAX
Route::get('/image-homes', [ImageHomeController::class, 'getImageHomes'])->name('image-homes.get');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

Route::group(['middleware' => 'guest'], function () {
    Route::get('login', function () {
        return view('admin.pages.auth.login');
    })->name('login');

    Route::post('login', [AuthController::class, 'login'])->name('login.post');
});
