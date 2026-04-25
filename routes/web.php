<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    $complaints = \App\Models\Complaint::where('user_id', $user->id)->get();

    $stats = [
        'total'    => $complaints->count(),
        'pending'  => $complaints->where('status', 'pending')->count(),
        'review'   => $complaints->where('status', 'under_review')->count(),
        'resolved' => $complaints->where('status', 'resolved')->count(),
    ];

    return view('dashboard', compact('stats'));
})->middleware(['auth'])->name('dashboard');

Route::get('/complaints/create', function () {
    return view('complaints.create');
})->middleware(['auth'])->name('complaints.create');

require __DIR__.'/auth.php';

Route::post('/api/scan-id', [App\Http\Controllers\IDVerificationController::class, 'scan']);

Route::get('/my-reports', function () {
    $user = auth()->user();
    $complaints = \App\Models\Complaint::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();
    return view('resident.my-reports', compact('complaints'));
})->middleware(['auth'])->name('my-reports');

Route::get('/track', function () {
    return view('resident.track');
})->middleware(['auth'])->name('track');

Route::get('/profile', function () {
    return view('resident.profile');
})->middleware(['auth'])->name('profile');

// ─── Admin Routes ───
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/complaints', [App\Http\Controllers\AdminController::class, 'complaints'])
        ->name('complaints');

    Route::post('/complaints/{complaint}/status', [App\Http\Controllers\AdminController::class, 'updateStatus'])
        ->name('complaints.status');

    Route::get('/users', [App\Http\Controllers\AdminController::class, 'users'])
        ->name('users');

    Route::post('/users/{user}/role', [App\Http\Controllers\AdminController::class, 'updateRole'])
        ->name('users.role');

    Route::post('/users/{user}/verify', [App\Http\Controllers\AdminController::class, 'toggleVerify'])
        ->name('users.verify');

    Route::delete('/users/{user}', [App\Http\Controllers\AdminController::class, 'deleteUser'])
        ->name('users.delete');

    Route::get('/analytics', [App\Http\Controllers\AdminController::class, 'analytics'])
        ->name('analytics');
});
