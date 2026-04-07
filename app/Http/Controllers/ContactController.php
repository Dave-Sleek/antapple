<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use App\Notifications\ContactMessageNotification;
use App\Models\User;

class ContactController extends Controller
{
    // use App\Models\ContactMessage;

    public function submitContact(Request $request)
    {
        // Honeypot check
        if ($request->filled('website')) {
            abort(403, 'Spam detected');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|min:10',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $contact = ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $admin = User::where('role', 'admin')->first();

        $admin->notify(new ContactMessageNotification($contact));

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
