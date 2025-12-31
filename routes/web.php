<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/auth/google', [AuthController::class, 'googleLogin']);

Route::middleware(['auth'])->group(function () {
    Route::middleware(['can:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            $stats = [
                'total_students' => \App\Models\User::where('role', 'student')->count(),
                'recent_registrations' => \App\Models\User::where('role', 'student')->where('created_at', '>=', now()->subDays(7))->count(),
            ];
            return view('admin.dashboard', compact('stats'));
        })->name('dashboard');

        Route::resource('students', \App\Http\Controllers\Admin\StudentController::class);
    });

    Route::get('/student/profile', [\App\Http\Controllers\Student\ProfileController::class, 'show'])->name('student.profile');
    Route::post('/student/profile', [\App\Http\Controllers\Student\ProfileController::class, 'update'])->name('student.profile.update');
});
