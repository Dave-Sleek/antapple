<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job_post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class EditorController extends Controller
{
    /**
     * Editor Dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Basic stats
        $totalJobs = Job_post::count();
        $activeJobs = Job_post::where('status', 'active')->count();
        $categoriesCount = Category::count();

        // Recent jobs
        $recentJobs = Job_post::latest()->take(5)->get();

        return view('editor.dashboard', compact(
            'user',
            'totalJobs',
            'activeJobs',
            'categoriesCount',
            'recentJobs'
        ));
    }
}