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

        // 🔥 CATEGORY COUNTS
        $typeCounts = Opportunity::where('is_active', true)
        ->selectRaw('type, COUNT(*) as total')
        ->groupBy('type')
        ->pluck('total', 'type');

        $opportunities = $query->latest()->paginate(12)->withQueryString();

        return view('opportunities.index', compact('opportunities', 'typeCounts'));
    }

    public function show($uuid, $slug)
    {
        $opportunity = Opportunity::where('uuid', $uuid)->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | SIMILAR OPPORTUNITIES (same type + location)
        |--------------------------------------------------------------------------
        */
        $similarOpportunities = Opportunity::where('id', '!=', $opportunity->id)
            ->where('type', $opportunity->type)
            ->when($opportunity->location, function ($q) use ($opportunity) {
                $q->where('location', 'like', "%{$opportunity->location}%");
            })
            ->latest()
            ->take(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RELATED OPPORTUNITIES (based on tags)
        |--------------------------------------------------------------------------
        */
        $relatedOpportunities = collect();

        if (!empty($opportunity->tags)) {

            $tags = array_map('trim', explode(',', $opportunity->tags));

            $relatedOpportunities = Opportunity::where('id', '!=', $opportunity->id)
                ->where(function ($query) use ($tags) {
                    foreach ($tags as $tag) {
                        $query->orWhere('tags', 'like', "%{$tag}%");
                    }
                })
                ->latest()
                ->take(10)
                ->get();
        }

        return view('opportunities.show', compact(
            'opportunity',
            'similarOpportunities',
            'relatedOpportunities'
        ));
    }
}