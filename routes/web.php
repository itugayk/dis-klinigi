<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TreatmentController;
use App\Livewire\BookingWizard;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/tedaviler', [TreatmentController::class, 'index'])->name('treatments.index');
Route::get('/tedaviler/{treatment}', [TreatmentController::class, 'show'])->name('treatments.show');

Route::get('/hekimler', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/hekimler/{doctor}', [DoctorController::class, 'show'])->name('doctors.show');

Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/iletisim', [ContactController::class, 'index'])->name('contact');
Route::post('/iletisim', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/randevu', BookingWizard::class)->name('booking');

// Coolify sağlık kontrolü (nginx de /up döndürür; bu yedek)
Route::get('/health', fn () => response()->json(['status' => 'ok', 'time' => now()->toIso8601String()]));
