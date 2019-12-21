<?php

namespace App\Providers;

use App\Category;
use App\Course;
use App\Observers\CategoryObserver;
use App\Observers\CourseObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Category::observe(CategoryObserver::class);
        Course::observe(CourseObserver::class);
    }
}
