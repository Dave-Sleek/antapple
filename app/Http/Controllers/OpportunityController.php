<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;

class OpportunityController extends Controller
{
    public function index(Request $request)
    {
        $query = Opportunity::active();

        // 🔍 Search
        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        // 🎯 Filter by type
        if ($request->type) {
            $query->where('type', $request->type);
        }

        // 📍 Location
        if ($request->location) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        $opportunities = $query->latest()->paginate(12)->withQueryString();

        return view('opportunities.index', compact('opportunities'));
    }

    public function show($uuid, $slug)
    {
        $opportunity = Opportunity::where('uuid', $uuid)->firstOrFail();

        return view('opportunities.show', compact('opportunity'));
    }
}