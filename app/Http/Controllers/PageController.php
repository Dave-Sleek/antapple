<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;

class PageController extends Controller
{
    public function privacy()
    {
        $seo = [
            'title' => 'Privacy Policy - AntApple Jobs',
            'description' => 'Learn how AntApple Jobs collects, uses, and protects your information. Verified jobs only.'
        ];
        return view('pages.privacy', compact('seo'));
    }

    public function terms()
    {
        $seo = [
            'title' => 'Terms of Use - AntApple Jobs',
            'description' => 'Read the AntApple Jobs Terms of Use. Verified jobs only, official company links only.'
        ];
        return view('pages.terms', compact('seo'));
    }

    public function cookies()
    {
        $seo = [
            'title' => 'Cookies Policy - AntApple Jobs',
            'description' => 'Understand how AntApple Jobs uses cookies to enhance your experience and deliver job alerts.'
        ];
        return view('pages.cookies', compact('seo'));
    }

    public function about()
    {
        $seo = [
            'title' => 'About Us - AntApple Jobs',
            'description' => 'Learn about AntApple Jobs, our mission to deliver verified job opportunities directly from official company websites.'
        ];
        return view('pages.about', compact('seo'));
    }

    public function contact()
    {
        $seo = [
            'title' => 'Contact Us - AntApple Jobs',
            'description' => 'Get in touch with AntApple Jobs. Send us questions, suggestions, or feedback.'
        ];
        return view('pages.contact', compact('seo'));
    }

    public function why()
    {
        $seo = [
            'title' => 'Why Choose AntApple Jobs? - AntApple Jobs',
            'description' => 'Discover why AntApple Jobs is the best choice for job seekers. Verified jobs only, official company links only.'
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
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|min:10',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
