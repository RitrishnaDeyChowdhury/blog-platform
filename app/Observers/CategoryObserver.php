<?php

namespace App\Observers;

use Illuminate\Support\Facades\{Cache, Log};
use App\Models\Category;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        Log::info("Cache cleared");
        Cache::forget('categories.all');
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        Log::info("Cache cleared");
        Cache::forget('categories.all');
        Cache::forget("category:{$category->id}");
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        // Log::info("Cache cleared");
        // Cache::forget('categories.all');
        // Cache::forget("category:{$category->id}");
    }

    /**
     * Handle the Category "restored" event.
     */
    public function restored(Category $category): void
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     */
    public function forceDeleted(Category $category): void
    {
        //
    }
}
