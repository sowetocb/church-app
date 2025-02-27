<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\CauseController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;

use App\Models\Cause;


// Public route for displaying causes (1 per page, auto-advance)
Route::get('/causes', [CauseController::class, 'index'])->name('causes.index');

Route::get('/', function () {
    return view('welcome');
});


Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/events/search', [EventController::class, 'search'])->name('event.search');




// Display event donations as cards (paginated: 3 per page)
Route::get('/cards/{event}', [DonationController::class, 'eventDonationCards'])->name('donations.cards');

Route::get('/causedonation/{cause}', [DonationController::class, 'createCauseDonation'])->name('donations.causes.create');
Route::post('/cause/{cause}/donate', [DonationController::class, 'storeCauseDonation'])->name('donations.causes.store');


// If you want to show a donation table for each cause:
Route::get('/causetable/{cause}', [DonationController::class, 'eventDonationTable'])->name('donations.table');


// Show all donations in one table
Route::get('/donations/all', [DonationController::class, 'allDonationsTable'])->name('donations.all');


// Display event donations as a table
Route::get('table/{event}', [DonationController::class, 'eventDonationTable'])->name('donations.table');

// Mobile payment info
Route::get('/donate/mobile-info', [DonationController::class, 'mobilePaymentInfo'])->name('donations.mobile.info');

Route::get('/my-own-donations', [DonationController::class, 'myOwnDonationEvents'])->name('donations.my.own');

Route::get('/my-own-cause', [DonationController::class, 'showMyOwnCause'])->name('donations.myOwnCause');

Route::get('/causes-donations', [DonationController::class, 'causesAndDonations'])
     ->name('donations.causes_donations');

// Approve donation (mark as paid)
Route::put('/donationsapprove/{donation}', [DonationController::class, 'approveDonation'])
     ->name('donations.approve');

     
Route::get('/reports/all-donations', [ReportController::class, 'allDonationsReport'])->name('reports.allDonations');
Route::get('/reports/donations-per-cause', [ReportController::class, 'donationsPerCause'])->name('reports.donationsPerCause');
Route::get('/reports/paid-pending', [ReportController::class, 'paidPendingReport'])->name('reports.paidPending');

// Or advanced
Route::get('/reports/paid-pending-by-cause', [ReportController::class, 'paidPendingByCause'])->name('reports.paidPendingByCause');

Route::get('/reports/all-donations/pdf', [ReportController::class, 'downloadAllDonationsPdf'])
     ->name('reports.allDonations.pdf');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth','role:admin'])->group(function(){
    Route::get('admin/dashboard', [AdminController::class, 'AdminDashboard'])->name ('admin.dashboard');
    Route::get('event/create', [EventController::class, 'create'])->name('event.create');
    Route::post('event/events', [EventController::class, 'store'])->name('event.store');
    Route::delete('event/{event}', [EventController::class, 'destroy'])->name('event.destroy');
    Route::post('/admin/users/{id}/update-role', [AdminController::class, 'updateRole'])->name('admin.updateRole');
    Route::get('/causes/create', [CauseController::class, 'create'])->name('causes.create');
    Route::post('/causes', [CauseController::class, 'store'])->name('causes.store');
    Route::delete('/causes/{cause}', [CauseController::class, 'destroy'])->name('causes.destroy');
    Route::get('admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::patch('admin/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::delete('admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/my-own-cause/donate', [DonationController::class, 'createMyOwnDonation'])->name('donations.myOwnDonate');
    Route::post('/my-own-cause/donate', [DonationController::class, 'storeMyOwnDonation'])->name('donations.myOwnDonateStore');
    Route::get('/my-own-cause/table', [DonationController::class, 'myOwnDonationTable'])
         ->name('donations.myOwnCause.table');

         Route::get('/my-donations', [DonationController::class, 'myDonationsReport'])
         ->name('reports.myDonations');   
});

Route::middleware(['auth','role:user'])->group(function(){
    Route::get('user/dashboard', [UserController::class, 'UserDashboard'])->name ('user.dashboard');

});
Route::get('/causes/partial', function (Request $request) {
    $causes = Cause::paginate(1);
    return view('donations.causes', compact('causes'));
})->name('causes.partial');

