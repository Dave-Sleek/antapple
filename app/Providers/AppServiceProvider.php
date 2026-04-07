<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use App\Models\Category;
use App\Observers\JobPostObserver;
use App\Models\Job_post;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('categories', Category::orderBy('name')->get());
        Job_post::observe(JobPostObserver::class);

        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {

            $footerCategories = Category::whereHas('jobPosts', function ($query) {
                $query->active();
            })
                ->withCount(['jobPosts' => function ($query) {
                    $query->active();
                }])
                ->orderByDesc('job_posts_count')
                ->limit(6)
                ->get();

            $footerLocations = Job_post::active()
                ->select('location')
                ->distinct()
                ->limit(6)
                ->pluck('location');

            $view->with(compact('footerCategories', 'footerLocations'));
        });

        // if (config('app.env') === 'local') {
        //     URL::forceScheme('https');
        // }
    }
}
