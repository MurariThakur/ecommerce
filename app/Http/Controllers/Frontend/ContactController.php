<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
            // 'cf-turnstile-response' => 'required'
        ]);

        $contact = Contact::create($request->only(['name', 'email', 'phone', 'subject', 'message']));

        Mail::to(config('mail.from.address'))->queue(new ContactFormMail($contact));

        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }
}