<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfController;
use App\Http\Controllers\CountController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExperienceController;
use App\Models\Experience;

Route::get('/', function () {
    return view('welcome');
});

Route::get('latihan', [CountController::class, 'index']);
Route::get('penjumlahan', [CountController::class, 'jumlah'])->name('penjumlahan');
Route::get('pengurangan', [CountController::class, 'kurang'])->name('pengurangan');
Route::get('perkalian', [CountController::class, 'kali'])->name('perkalian');
Route::get('pembagian', [CountController::class, 'bagi'])->name('pembagian');
Route::post('storejumlah', [CountController::class, 'storejumlah'])->name('store_penjumlahan');
Route::post('storekurang', [CountController::class, 'storekurang'])->name('store_pengurangan');
Route::post('storekali', [CountController::class, 'storekali'])->name('store_perkalian');
Route::post('storebagi', [CountController::class, 'storebagi'])->name('store_pembagian');

Route::get('/dashboard', function () {
    if (Auth::user()->id_level === 1) {
        return view('admin.dashboard');
    } elseif (Auth::user()->id_level === 2) {
        return view('user.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('admin/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'admin']);
Route::get('user/dashboard', [HomeController::class, 'indexUser'])->middleware(['auth', 'user']);

Route::get('admin/profile', [ProfController::class, 'index'])->name('profile.index')->middleware(['auth', 'admin']);
Route::get('admin/profile/create', [ProfController::class, 'create'])->name('profile.create')->middleware(['auth', 'admin']);
Route::POST('admin/profile/store', [ProfController::class, 'store'])->name('profile.store')->middleware(['auth', 'admin']);
Route::get('admin/profile/edit/{id}', [ProfController::class, 'edit'])->name('profile.edit')->middleware(['auth', 'admin']);

//Update dan softdelete
Route::get('admin/profile/edit/{id}', [ProfController::class, 'edit'])->name('profile.edit')->middleware(['auth', 'admin']);
Route::put('admin/profile/update/{id}', [ProfController::class, 'update'])->name('profile.update')->middleware(['auth', 'admin']);
Route::delete('admin/profile/softdelete/{id}', [ProfController::class, 'softdelete'])->name('profile.softdelete')->middleware(['auth', 'admin']);
//status
Route::post('admin/profile/update-status/{id}', [ProfController::class, 'update_status'])->name('profiles.update_status');

//Website CV
Route::get('/compro', [ContentController::class, 'index']);

//Recycle dan Restore
Route::get('admin/recycle', [ProfController::class, 'recycle'])->name('profile.recycle');
Route::get('admin/restore/{id}', [ProfController::class, 'restore'])->name('profile.restore');

Route::delete('admin/destroy/{id}', [ProfController::class, 'destroy'])->name('profile.destroy');

//Experience
Route::get('admin/experience', [ExperienceController::class, 'index'])->name('experience.index')->middleware(['auth', 'admin']);
Route::get('admin/experience/create', [ExperienceController::class, 'create'])->name('experience.create')->middleware(['auth', 'admin']);
Route::POST('admin/experience/store', [ExperienceController::class, 'store'])->name('experience.store')->middleware(['auth', 'admin']);

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
