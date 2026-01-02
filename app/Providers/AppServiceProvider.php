<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Repository\PostRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Bind the PostRepository as a singleton if needed
        $this->app->singleton(PostRepository::class, function ($app) {
            return new PostRepository();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Safely share categories with all views
        view()->composer('*', function ($view) {
            // Pull real categories from database
            $categories = Category::all();
            $view->with('categories', $categories);
        });

    }
}
