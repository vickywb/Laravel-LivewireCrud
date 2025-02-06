<?php

use App\Livewire\Home;
use App\Livewire\Article\Article;
use App\Livewire\Category\Category;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/categories', Category::class)->name('category');
Route::get('/articles', Article::class)->name('article');