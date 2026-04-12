<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OpportunityController extends Controller
{
    public function index()
    {
        $opportunities = Opportunity::latest()->paginate(15);

        return view('admin.opportunities.index', compact('opportunities'));
    }

    public function create()
    {
        return view('admin.opportunities.create');
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'type' => 'required',
        'organization' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'location' => 'nullable|string|max:255',
        'salary_range' => 'nullable|string|max:255',
        'funding_type' => 'nullable|string|max:255',
        'deadline' => 'nullable|date',
        'apply_url' => 'nullable|url',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

        $data['user_id'] = auth::id();

    // 🖼 IMAGE UPLOAD
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('opportunities', 'public');
            $data['image'] = $path;
        }


        $data['uuid'] = (string) Str::uuid();
        $data['slug'] = Str::slug($data['title']);

        Opportunity::create($data);


        $opportunity = Opportunity::create($data);

if ($opportunity && config('services.telegram.bot_token')) {

    $message = "🎯 *New Opportunity*\n\n"
        . "*{$opportunity->title}*\n"
        . "🏢 {$opportunity->organization}\n"
        . "📍 {$opportunity->location}\n"
        . "🔗 " . route('opportunities.show', [$opportunity->uuid, $opportunity->slug]);

    Http::post(
        "https://api.telegram.org/bot" . config('services.telegram.bot_token') . "/sendMessage",
        [
            'chat_id' => config('services.telegram.chat_id'),
            'text' => $message,
            'parse_mode' => 'Markdown'
        ]
    );
}

        return redirect()->route('admin.opportunities.index')
            ->with('success', 'Opportunity created successfully.');
    }

    public function edit(Opportunity $opportunity)
    {
        return view('admin.opportunities.edit', compact('opportunity'));
    }

    public function update(Request $request, Opportunity $opportunity)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'type' => 'required',
        'organization' => 'nullable|string|max:255',
        'description' => 'nullable|string',
        'location' => 'nullable|string|max:255',
        'salary_range' => 'nullable|string|max:255',
        'funding_type' => 'nullable|string|max:255',
        'deadline' => 'nullable|date',
        'apply_url' => 'nullable|url',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

        $data['user_id'] = auth::id();

    // 🖼 Replace image if new one uploaded
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('opportunities', 'public');
            $data['image'] = $path;
        }

        $data['slug'] = Str::slug($data['title']);

        $opportunity->update($data);

        return redirect()->route('admin.opportunities.index')
            ->with('success', 'Opportunity updated successfully.');
    }

    public function destroy(Opportunity $opportunity)
    {
        $opportunity->delete();

        return back()->with('success', 'Opportunity deleted.');
    }
}