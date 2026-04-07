<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Job_post;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    // Show list of all companies
    public function index(Request $request)
    {
        $query = User::where('role', 'employer')
            ->whereHas('jobs', function ($q) {
                $q->where('status', 'active'); // only companies with active jobs
            });

        // $query = User::where('role', 'employer')->whereHas('jobs', function ($q) {
        //     $q->where('status', 'active');
        // })->with(['jobs' => function ($q) {
        //     $q->where('status', 'active')->select('id', 'user_id', 'is_verified');
        // }]);

        // 🔍 Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // 🔄 Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'jobs_desc':
                    $query->withCount('jobs')->orderBy('jobs_count', 'desc');
                    break;
                case 'jobs_asc':
                    $query->withCount('jobs')->orderBy('jobs_count', 'asc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        // 📊 Items per page
        $perPage = $request->get('perPage', 12);

        $companies = $query->paginate($perPage)->appends($request->query());

        return view('companies.index', compact('companies'));
    }


    // Show single company profile with active jobs
    // public function show(User $user)
    // {
    //     $jobs = Job_post::where('user_id', $user->id)
    //         ->where('status', 'active')
    //         ->latest()
    //         ->get();

    //     return view('companies.show', compact('user', 'jobs'));
    // }

    public function show(User $user)
    {
        // Load only active jobs
        $jobs = Job_post::where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('companies.show', compact('user', 'jobs'));
    }
}
