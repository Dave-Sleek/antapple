<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers',
        ]);

        Subscriber::create($request->only('email', 'preferred_category_id'));

        return back()->with('success', 'Subscribed successfully');
    }
}
