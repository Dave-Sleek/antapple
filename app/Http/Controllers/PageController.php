<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Notifications\ContactMessageNotification;

class PageController extends Controller
{
    public function privacy()
    {
        $seo = [
            'title' => 'Privacy Policy - Sproutplex Jobs',
            'description' => 'Learn how Sproutplex Jobs collects, uses, and protects your information. Verified jobs only.'
        ];
        return view('pages.privacy', compact('seo'));
    }

    public function terms()
    {
        $seo = [
            'title' => 'Terms of Use - Sproutplex Jobs',
            'description' => 'Read the Sproutplex Jobs Terms of Use. Verified jobs only, official company links only.'
        ];
        return view('pages.terms', compact('seo'));
    }

    public function cookies()
    {
        $seo = [
            'title' => 'Cookies Policy - Sproutplex Jobs',
            'description' => 'Understand how Sproutplex Jobs uses cookies to enhance your experience and deliver job alerts.'
        ];
        return view('pages.cookies', compact('seo'));
    }

    public function about()
    {
        $seo = [
            'title' => 'About Us - Sproutplex Jobs',
            'description' => 'Learn about Sproutplex Jobs, our mission to deliver verified job opportunities directly from official company websites.'
        ];
        return view('pages.about', compact('seo'));
    }

    public function contact()
    {
        $seo = [
            'title' => 'Contact Us - Sproutplex Jobs',
            'description' => 'Get in touch with Sproutplex Jobs. Send us questions, suggestions, or feedback.'
        ];
        return view('pages.contact', compact('seo'));
    }

    public function why()
    {
        $seo = [
            'title' => 'Why Choose Sproutplex Jobs? - Sproutplex Jobs',
            'description' => 'Discover why Sproutplex Jobs is the best choice for job seekers. Verified jobs only, official company links only.'
        ];
        return view('pages.why', compact('seo'));
    }


   public function submitContact(Request $request)
{
    // Honeypot check
    if ($request->filled('website')) {
        abort(403, 'Spam detected');
    }

    $request->validate([
        'name'            => 'required|string|max:255',
        'email'           => 'required|email',
        'message'         => 'required|min:10',
        'g-recaptcha-response' => 'required',
    ]);

    // Verify reCAPTCHA
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'secret'   => config('services.recaptcha.secret'),
        'response' => $request->input('g-recaptcha-response'),
        'remoteip' => $request->ip(),
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $raw = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($raw, true);

    if (!($result['success'] ?? false)) {
        return back()->withErrors(['captcha' => 'reCAPTCHA failed. Try again.']);
    }

    // Save message
    $contact = ContactMessage::create([
        'name'       => $request->name,
        'email'      => $request->email,
        'subject'    => $request->subject,
        'message'    => $request->message,
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);

    // Notify admin
    $admin = User::where('role', 'admin')->first();
    if ($admin) {
        $admin->notify(new ContactMessageNotification($contact));
    }

    // Optionally notify the user (confirmation email)
    $user = new User([
        'email' => $request->email,
        'name'  => $request->name,
    ]);
    $user->notify(new ContactMessageNotification($contact));

    return back()->with('success', 'Your message has been sent successfully!');
}
}
