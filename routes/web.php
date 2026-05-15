<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

// ─── Landing Page (public) ───
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/offline', function () {
    return view('offline');
})->name('offline');

// ─── OCR Scan Route (backend proxy - hides API key) ───
Route::post('/ocr/scan', function (Request $request) {
    $base64 = $request->input('image');

    $response = Http::withHeaders([
        'apikey' => env('OCR_SPACE_KEY')
    ])->asForm()->post('https://api.ocr.space/parse/image', [
        'base64Image'       => $base64,
        'language'          => 'eng',
        'isOverlayRequired' => 'false',
        'detectOrientation' => 'true',
        'scale'             => 'true',
        'OCREngine'         => '2',
    ]);

    return response()->json($response->json());
})->middleware(['web'])->name('ocr.scan');

// ─── Dashboard (role-based redirect) ───
Route::get('/dashboard', function () {
    $user = auth()->user();
    $role = $user->getRoleNames()->first();

    if (in_array($role, ['admin'])) {
        return redirect()->route('admin.dashboard');
    }

    $complaints = \App\Models\Complaint::where('user_id', $user->id)->get();
    $stats = [
        'total'      => $complaints->count(),
        'pending'    => $complaints->where('status', 'pending')->count(),
        'inprogress' => $complaints->whereIn('status', ['for_review', 'approved', 'scheduled', 'ongoing'])->count(),
        'resolved'   => $complaints->where('status', 'resolved')->count(),
    ];
    $recent = $complaints->sortByDesc('created_at')->take(5);

    return view('dashboard', compact('stats', 'recent'));
})->middleware(['auth'])->name('dashboard');

// ─── Resident Routes ───
Route::get('/complaints/create', [App\Http\Controllers\ComplaintController::class, 'create'])
    ->middleware(['auth'])->name('complaints.create');

Route::post('/complaints', [App\Http\Controllers\ComplaintController::class, 'store'])
    ->middleware(['auth'])->name('complaints.store');

Route::get('/my-reports', function () {
    $complaints = \App\Models\Complaint::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')->get();
    return view('resident.my-reports', compact('complaints'));
})->middleware(['auth'])->name('my-reports');

Route::get('/track', function () {
    return view('resident.track');
})->middleware(['auth'])->name('track');

Route::get('/profile', function () {
    return view('resident.profile');
})->middleware(['auth'])->name('profile');

Route::patch('/profile/update', function (Request $request) {
    $user = auth()->user();
    $request->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
    ]);
    $user->update(['name' => $request->name, 'email' => $request->email]);
    return back()->with('success', 'Profile updated successfully!');
})->middleware(['auth'])->name('profile.update');

// ─── Notifications (Resident) ───
Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])
    ->middleware(['auth'])->name('notifications');

Route::patch('/notifications/{notification}/read', [App\Http\Controllers\NotificationController::class, 'markRead'])
    ->middleware(['auth'])->name('notifications.read');

Route::get('/notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'unreadCount'])
    ->middleware(['auth'])->name('notifications.count');

// ─── Admin Routes ───
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/complaints', [App\Http\Controllers\AdminController::class, 'complaints'])
        ->name('complaints');

    Route::get('/complaints/{complaint}', [App\Http\Controllers\AdminController::class, 'show'])
        ->name('complaints.show');

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

    // ─── PDF Form Generation ───
    Route::get('/complaints/{complaint}/form/7',  [App\Http\Controllers\AdminController::class, 'formComplainant'])->name('complaints.form7');
    Route::get('/complaints/{complaint}/form/8',  [App\Http\Controllers\AdminController::class, 'formNoticeHearing'])->name('complaints.form8');
    Route::get('/complaints/{complaint}/form/9',  [App\Http\Controllers\AdminController::class, 'formSummons'])->name('complaints.form9');
    Route::get('/complaints/{complaint}/form/16', [App\Http\Controllers\AdminController::class, 'formSettlement'])->name('complaints.form16');
    Route::get('/complaints/{complaint}/form/22', [App\Http\Controllers\AdminController::class, 'formCFA'])->name('complaints.form22');
    Route::get('/complaints/{complaint}/form/10', [App\Http\Controllers\AdminController::class, 'formPangkat'])->name('complaints.form10');
    Route::get('/complaints/{complaint}/form/11', [App\Http\Controllers\AdminController::class, 'formPangkatMember'])->name('complaints.form11');
    Route::get('/complaints/{complaint}/form/13', [App\Http\Controllers\AdminController::class, 'formSubpoena'])->name('complaints.form13');
    Route::get('/complaints/{complaint}/form/14', [App\Http\Controllers\AdminController::class, 'formArbitration'])->name('complaints.form14');
    Route::get('/complaints/{complaint}/form/15', [App\Http\Controllers\AdminController::class, 'formArbitrationAward'])->name('complaints.form15');
    Route::get('/complaints/{complaint}/form/18', [App\Http\Controllers\AdminController::class, 'formNoticeComplainant'])->name('complaints.form18');
    Route::get('/complaints/{complaint}/form/19', [App\Http\Controllers\AdminController::class, 'formNoticeRespondent'])->name('complaints.form19');
    Route::get('/complaints/{complaint}/form/20', [App\Http\Controllers\AdminController::class, 'formCFALupon'])->name('complaints.form20');
    Route::get('/complaints/{complaint}/form/25', [App\Http\Controllers\AdminController::class, 'formMotionExecution'])->name('complaints.form25');
    Route::get('/complaints/{complaint}/form/27', [App\Http\Controllers\AdminController::class, 'formNoticeExecution'])->name('complaints.form27');
});

require __DIR__.'/auth.php';