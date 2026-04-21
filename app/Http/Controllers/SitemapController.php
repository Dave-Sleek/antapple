<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use App\Models\Job_post;
use App\Models\Opportunity;
use App\Models\Category;

class SitemapController extends Controller
{
    /*
    |------------------------------------------
    | SITEMAP INDEX (now lightweight)
    |------------------------------------------
    */
    public function index()
    {
        // Get distinct months for jobs
        $jobMonths = Job_post::where('status', 'active')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
            ->distinct()
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        // Get distinct months for opportunities
        $oppMonths = Opportunity::where('status', 'active')
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month')
            ->distinct()
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        $categories = Category::all();

        return response()
            ->view('sitemap.index', compact('jobMonths', 'oppMonths', 'categories'))
            ->header('Content-Type', 'text/xml');
    }

    /*
    |------------------------------------------
    | JOBS (DATE SPLIT + CACHE)
    |------------------------------------------
    */
    public function jobsByDate($year, $month)
    {
        $cacheKey = "sitemap_jobs_{$year}_{$month}";

        return Cache::remember($cacheKey, 3600, function () use ($year, $month) {

            $jobs = Job_post::where('status', 'active')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->latest()
                ->get();

            return response()
                ->view('sitemap.jobs', compact('jobs'))
                ->header('Content-Type', 'text/xml');
        });
    }

    /*
    |------------------------------------------
    | OPPORTUNITIES (DATE SPLIT + CACHE)
    |------------------------------------------
    */
    public function opportunitiesByDate($year, $month)
    {
        $cacheKey = "sitemap_opportunities_{$year}_{$month}";

        return Cache::remember($cacheKey, 3600, function () use ($year, $month) {

            $opportunities = Opportunity::where('status', 'active')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->latest()
                ->get();

            return response()
                ->view('sitemap.opportunities', compact('opportunities'))
                ->header('Content-Type', 'text/xml');
        });
    }

    /*
    |------------------------------------------
    | CATEGORY SITEMAP (also cached)
    |------------------------------------------
    */
    public function category($slug)
    {
        $cacheKey = "sitemap_category_{$slug}";

        return Cache::remember($cacheKey, 3600, function () use ($slug) {

            $category = Category::where('slug', $slug)->firstOrFail();

            $jobs = $category->jobs()->where('status', 'active')->get();
            $opportunities = $category->opportunities()->where('status', 'active')->get();

            return response()
                ->view('sitemap.category', compact('category', 'jobs', 'opportunities'))
                ->header('Content-Type', 'text/xml');
        });
    }
}