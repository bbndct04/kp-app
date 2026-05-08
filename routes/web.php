<?php

use Illuminate\Support\Facades\Route;

// ─── Landing Page (public) ───
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/offline', function () {
    return view('offline');
})->name('offline');

// ─── Dashboard (role-based redirect) ───
Route::get('/dashboard', function () {
    $user = auth()->user();
    $role = $user->getRoleNames()->first();

    if (in_array($role, ['admin', 'staff'])) {
        return redirect()->route('admin.dashboard');
    }

    $complaints = \App\Models\Complaint::where('user_id', $user->id)->get();
    $stats = [
        'total'      => $complaints->count(),
        'pending'    => $complaints->where('status','pending')->count(),
        'inprogress' => $complaints->whereIn('status',['for_review','approved','scheduled','ongoing'])->count(),
        'resolved'   => $complaints->where('status','resolved')->count(),
    ];
    $recent = $complaints->sortByDesc('created_at')->take(5);

    return view('dashboard', compact('stats','recent'));
})->middleware(['auth'])->name('dashboard');

// ─── Resident Routes ───
Route::get('/complaints/create', [App\Http\Controllers\ComplaintController::class, 'create'])
    ->middleware(['auth'])->name('complaints.create');

Route::post('/complaints', [App\Http\Controllers\ComplaintController::class, 'store'])
    ->middleware(['auth'])->name('complaints.store');

Route::get('/my-reports', function () {
    $complaints = \App\Models\Complaint::where('user_id', auth()->id())
        ->orderBy('created_at','desc')->get();
    return view('resident.my-reports', compact('complaints'));
})->middleware(['auth'])->name('my-reports');

Route::get('/track', function () {
    return view('resident.track');
})->middleware(['auth'])->name('track');

Route::get('/profile', function () {
    return view('resident.profile');
})->middleware(['auth'])->name('profile');

Route::patch('/profile/update', function (\Illuminate\Http\Request $request) {
    $user = auth()->user();
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$user->id,
    ]);
    $user->update(['name' => $request->name, 'email' => $request->email]);
    return back()->with('success', 'Profile updated successfully!');
})->middleware(['auth'])->name('profile.update');

// ─── ID Scan API ───
Route::post('/api/scan-id', [App\Http\Controllers\IDVerificationController::class, 'scan']);

// ─── Admin + Staff Routes (both roles merged) ───
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

// ─── Staff Routes (complaint detail + KP forms) ───
Route::prefix('staff')->middleware(['auth'])->name('staff.')->group(function () {

    Route::get('/complaints/{complaint}', [App\Http\Controllers\StaffController::class, 'show'])
        ->name('complaints.show');

    Route::post('/complaints/{complaint}/validate', [App\Http\Controllers\StaffController::class, 'validate'])
        ->name('complaints.validate');

    Route::post('/complaints/{complaint}/mediation', [App\Http\Controllers\StaffController::class, 'mediation'])
        ->name('complaints.mediation');

    Route::post('/complaints/{complaint}/close', [App\Http\Controllers\StaffController::class, 'close'])
        ->name('complaints.close');

    Route::get('/complaints/{complaint}/form/{formNumber}', [App\Http\Controllers\StaffController::class, 'generateForm'])
        ->name('complaints.form');
});

require __DIR__.'/auth.php';