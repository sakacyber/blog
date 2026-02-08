<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // admin
    Route::group(['prefix' => '/admin'], function () {
        Route::resource('posts',PostController::class);
        Route::resource('categories', CategoryController::class)->except('show');
        Route::resource('authors',AuthorController::class);
    });

    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
});


// Outside the middleware group, add a route to display posts publicly:
//Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
//Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

// frontend pages
Route::get('/', 'PageController@index')->name('home');
Route::get('/posts', 'PageController@posts')->name('posts.index');
Route::get('/posts/{post}', 'PageController@showPost')->name('posts.view');
Route::get('/category/{category}', 'PageController@showCategory')->name('categories.view');


Route::get('admin', [AdminController::class,'index'])->name('admin');
Route::resource('admin/roles', 'Admin\RolesController');
Route::resource('admin/permissions', 'Admin\PermissionsController');
Route::resource('admin/users', 'Admin\UsersController');
Route::resource('admin/pages', 'Admin\PagesController');
Route::resource('admin/activitylogs', 'Admin\ActivityLogsController')
    ->only(['index', 'show', 'destroy']);
Route::resource('admin/settings', 'Admin\SettingsController');
Route::get('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@getGenerator']);
Route::post('admin/generator', ['uses' => '\Appzcoder\LaravelAdmin\Controllers\ProcessController@postGenerator']);

require __DIR__.'/auth.php';
