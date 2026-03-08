<?php

use App\Livewire\Admin\Posts\Form;
use App\Livewire\Blog\Index as BlogIndex;
use App\Livewire\Blog\Show as BlogShow;
use Illuminate\Support\Facades\Route;

Route::get('/', BlogIndex::class)->name('home');
Route::get('/blog/{slug}', BlogShow::class)->name('blog.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('dashboard/posts/create', Form::class)->name('admin.posts.create');
    Route::get('dashboard/posts/{post}/edit', Form::class)->name('admin.posts.edit');
});

require __DIR__.'/settings.php';

