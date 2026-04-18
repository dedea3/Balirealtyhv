<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VillaController as AdminVillaController;
use App\Http\Controllers\Admin\AmenityController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\iCalController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AreaController;
use App\Http\Controllers\Frontend\VillaController as FrontendVillaController;
use App\Http\Controllers\Frontend\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/destinations', [AreaController::class, 'index'])->name('areas.index');
Route::get('/destinations/{area:slug}', [AreaController::class, 'show'])->name('areas.show');
Route::get('/villas/{villa:slug}', [FrontendVillaController::class, 'show'])->name('villas.show');
Route::post('/villas/{villa:slug}/inquire', [FrontendVillaController::class, 'inquire'])->name('villas.inquire');
Route::get('/about', [ContactController::class, 'about'])->name('about');
Route::get('/contact', [ContactController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Redirects
Route::get('/admin', function() {
    return redirect()->route('admin.dashboard');
});
Route::get('/login', function() {
    return redirect()->route('admin.login');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest routes (login)
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.post');
    });

    // Authenticated admin routes
    Route::middleware('admin')->group(function () {
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Villas
        Route::resource('villas', AdminVillaController::class);
        Route::post('villas/{villa}/rates', [AdminVillaController::class, 'updateRates'])->name('villas.rates.update');
        Route::post('villas/{villa}/photos', [AdminVillaController::class, 'uploadPhotos'])->name('villas.photos.upload');
        Route::delete('villas/photos/bulk', [AdminVillaController::class, 'bulkDeletePhotos'])->name('villas.photos.bulk-delete');
        Route::post('villas/photos/{photo}/primary', [AdminVillaController::class, 'setPrimaryPhoto'])->name('villas.photos.primary');
        Route::delete('villas/photos/{photo}', [AdminVillaController::class, 'deletePhoto'])->name('villas.photos.delete');

        // Amenities
        Route::resource('amenities', AmenityController::class);
        Route::resource('amenity-categories', AmenityController::class)->names('amenity.categories');

        // Inquiries
        Route::resource('inquiries', InquiryController::class)->only(['index', 'show', 'update', 'destroy']);
        Route::post('inquiries/{inquiry}/status', [InquiryController::class, 'updateStatus'])->name('inquiries.status');
        Route::post('inquiries/{inquiry}/assign', [InquiryController::class, 'assign'])->name('inquiries.assign');

        // Reviews
        Route::resource('reviews', ReviewController::class);
        Route::post('reviews/{review}/toggle-publish', [ReviewController::class, 'togglePublish'])->name('reviews.toggle-publish');
        Route::post('reviews/{review}/respond', [ReviewController::class, 'respond'])->name('reviews.respond');

        // iCal Sync
        Route::get('ical/export/{villa}', [iCalController::class, 'export'])->name('ical.export');
        Route::post('ical/import', [iCalController::class, 'import'])->name('ical.import');
        Route::post('ical/sync/{villa}', [iCalController::class, 'sync'])->name('ical.sync');
    });
});
