<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OpportunityClick;
use Illuminate\Support\Facades\Log;
use App\Models\OpportunityView;

class OpportunityController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check() && !Auth::user()->is_active) {
                return redirect()->route('account.suspended');
            }

        $query = Opportunity::active();

        // 🔍 Search
        if ($request->search) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        // Filter by type
        if ($request->type) {
            $query->where('type', $request->type);
        }

        //  Location
        if ($request->location) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        //  CATEGORY COUNTS
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

        // Increment views whenever detail page is opened
         // Track unique view
                $userId = Auth::id();
                $ip = request()->ip();
                $sessionId = session()->getId();

                $alreadyViewed = OpportunityView::where('opportunity_id', $opportunity->id)
                    ->where(function ($query) use ($userId, $ip) {
                        if ($userId) {
                            $query->where('user_id', $userId);
                        } else {
                            $query->where('ip_address', $ip);
                        }
                    })
                    ->exists();

                if (!$alreadyViewed) {
                    OpportunityView::create([
                        'opportunity_id' => $opportunity->id,
                        'user_id' => $userId,
                        'ip_address' => $ip,
                        'session_id' => $sessionId,
                    ]);

                    // increment counter
                    $opportunity->increment('views');
                }


                 /*
        |--------------------------------------------------------------------------
        | HOT OPPORTUNITIES (same type + location)
        |--------------------------------------------------------------------------
        */
        

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

       public function apply($uuid)
{
    $opportunity = Opportunity::where('uuid', $uuid)->firstOrFail();

    $userId = Auth::id();
    $ip = request()->ip();
    $sessionId = session()->getId();

    // Check if already clicked
    $alreadyClicked = OpportunityClick::where('opportunity_id', $opportunity->id)
        ->where(function ($query) use ($userId, $ip) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('ip_address', $ip);
            }
        })
        ->exists();

    if (!$alreadyClicked) {
        OpportunityClick::create([
            'opportunity_id' => $opportunity->id,
            'user_id' => $userId,
            'ip_address' => $ip,
            'session_id' => $sessionId,
        ]);

        // increment only once
        $opportunity->increment('clicks');
    }

    // Ensure valid URL
    $url = $opportunity->apply_url;
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "https://" . $url;
    }

    return redirect()->away($url);


    $alreadyClicked = OpportunityClick::where('opportunity_id', $opportunity->id)
    ->where(function ($query) use ($userId, $ip) {
        if ($userId) {
            $query->where('user_id', $userId);
        } else {
            $query->where('ip_address', $ip);
        }
    })
    ->where('created_at', '>=', now()->subDay())
    ->exists();


    Log::info('Opportunity clicked', [
    'opportunity_id' => $opportunity->id,
    'user_id' => auth::id(),
    'ip' => request()->ip()
]);
}


}