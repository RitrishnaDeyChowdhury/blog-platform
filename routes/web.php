<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\{BlogController, NotificationController, ProfileController};
use App\Http\Controllers\Frontend\CategoryBlogController;
use App\Http\Controllers\Admin\{BlogApprovalController, CategoryController, TagController};

// Route::get('/', function () {
//   return redirect()->route('login');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware(['auth', RoleMiddleware::class . ':admin'])
    ->group(function () {
        Route::resource('categories', CategoryController::class);

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('tags',TagController::class)
			->only('index','store','create');

		Route::get('/blogs/pending', [BlogApprovalController::class, 'index'])
            ->name('blogs.pending');

        Route::patch('/blogs/update-status', [BlogApprovalController::class, 'updateStatus'])
            ->name('blogs.updateStatus');

		Route::resource('blogs', BlogController::class);
    });

Route::middleware(['auth', RoleMiddleware::class . ':author'])
    ->group(function () {
		Route::get('/dashboard', function () {
			return view('admin.dashboard');
		})->name('dashboard');

		Route::resource('tags',TagController::class);


		Route::resource('blogs', BlogController::class);
    
	});

	Route::get('/viewer/dashboard', function () {
		return 'Viewer Dashboard';
	})->middleware(['auth', RoleMiddleware::class . ':viewer'])->name('viewer.dashboard');

	Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.show');
	Route::get('notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');

	// Frontend Routes

	Route::get('/', [CategoryBlogController::class, 'index'])->name('blog.index');
	Route::get('/blog/{slug}', [CategoryBlogController::class, 'show'])->name('blog.show');
	Route::get('/category/{slug}', [CategoryBlogController::class, 'category'])->name('blog.category');
	Route::post('/review/{blog}', [CategoryBlogController::class, 'store'])->name('review.store');
	Route::get('/search',[CategoryBlogController::class,'search'])->name('blog.search');

require __DIR__.'/auth.php';
