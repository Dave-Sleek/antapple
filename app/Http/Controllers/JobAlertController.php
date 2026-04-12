<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JobAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobAlertController extends Controller
{
    /**
     * Subscribe a user to job alerts.
     */
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'email'        => 'required|email',
            'alert_type' => 'required|in:job,opportunity',
            'category_id'  => 'nullable|exists:categories,id',
            'opportunity_type' => 'nullable|string',
            'location'     => 'nullable|string|max:255',
            'remote_only'  => 'nullable|boolean',
            'frequency'    => 'nullable|in:daily,weekly,instant',
            'terms'        => 'accepted',
        ]);

        // Normalize fields
        $data['remote_only'] = $request->boolean('remote_only');
        $data['frequency']   = $data['frequency'] ?? 'daily';
        $data['is_active']   = true;

        // Clean location: remove extra spaces
        if (!empty($data['location'])) {
            $data['location'] = collect(explode(',', $data['location']))
                ->map(fn($loc) => trim($loc))
                ->implode(',');
        }

        // Create or update the alert
        $alert = JobAlert::updateOrCreate(
            ['email' => $data['email']],
            $data
        );

        // Generate unsubscribe token if missing
        if (empty($alert->unsubscribe_token)) {
            $alert->unsubscribe_token = Str::uuid();
            $alert->save();
        }

        return back()->with('success', 'You are now subscribed to job alerts!');
    }

    /**
     * Unsubscribe a user using their token.
     */
    public function unsubscribe($token)
    {
        $alert = JobAlert::where('unsubscribe_token', $token)->firstOrFail();
        $alert->update(['is_active' => false]);

        return redirect()->route('jobs.index')
            ->with('success', 'You have unsubscribed from job alerts.');
    }
}
