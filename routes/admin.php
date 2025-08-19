<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SocialController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CkeditorController;
use App\Http\Controllers\Admin\LogoSiteController;
use App\Http\Controllers\Admin\FranchiseController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\DressStyleController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\CategoryBlogController;
use App\Http\Controllers\Admin\FeatureSectionController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\FranchiseContactController;
use App\Http\Controllers\Admin\LanguageController;

Route::group(['as' => 'admin.'], function () {
    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return 'Cache cleared';
    })->name('clear.cache');

    Route::group(['middleware' => ['auth', 'check.role:admin']], function () {
        Route::get('/', function () {
            return view('admin.pages.dashboard');
        })->name('dashboard');

        Route::get('logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('logo-site', [LogoSiteController::class, 'edit'])->name('logo-site.edit');
        Route::put('logo-site', [LogoSiteController::class, 'update'])->name('logo-site.update');

        // Language Management
        Route::get('languages', [LanguageController::class, 'index'])->name('languages.index');
        Route::get('languages/get', [LanguageController::class, 'getLanguageContent'])->name('languages.get');
        Route::post('languages/update', [LanguageController::class, 'updateLanguageContent'])->name('languages.update');
        Route::post('languages/create', [LanguageController::class, 'createLanguageFile'])->name('languages.create');

        Route::resource('category-blogs', CategoryBlogController::class)->except(['show']);
        Route::resource('blogs', BlogController::class)->except(['show']);

        Route::post('blogs/upload-image', [BlogController::class, 'uploadImage'])->name('blogs.upload.image');
        Route::get('blogs/load-categories', [BlogController::class, 'loadCategories'])->name('blogs.load-categories');

        Route::resource('banners', BannerController::class)->except(['show']);

        Route::resource('socials', SocialController::class)->except(['show']);


        Route::post('ckeditor/upload', [CkeditorController::class, 'upload'])
            ->name('ckeditor.upload');

        Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
        Route::put('setting/order', [SettingController::class, 'updateOrder'])->name('setting.update.order');
        Route::put('setting/smtp', [SettingController::class, 'updateSMTP'])->name('setting.update.smtp');
        Route::put('setting/google', [SettingController::class, 'updateGoogle'])->name('setting.update.google');
        Route::put('setting/paypal', [SettingController::class, 'updatePaypal'])->name('setting.update.paypal');

    });

    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', function () {
            return view('admin.pages.auth.login');
        })->name('login');

        Route::post('login', [AuthController::class, 'login'])->name('login.post');
    });
});
