<?php

use App\Livewire\Admin\Posts\Form;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('dashboard/posts/create', Form::class)->name('admin.posts.create');
    Route::get('dashboard/posts/{post}/edit', Form::class)->name('admin.posts.edit');
});

require __DIR__.'/settings.php';

