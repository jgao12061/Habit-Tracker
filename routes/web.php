<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HabitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;


Route::get('/register', function () {
    return view('auth.register');
})->name('register.index');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::post('/register', [RegisterController::class, 'store'])->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/profile/index', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/index', [ProfileController::class, 'update'])->name('profile.update');
});

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('habits', HabitController::class);
    Route::patch('habits/{habit}/toggle', [HabitController::class, 'toggle'])->name('habits.toggle');
});