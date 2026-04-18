<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Mail\InquiryNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function contact()
    {
        return view('frontend.contact.index');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Create as general inquiry (no villa assigned)
        $inquiry = Inquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'message' => "Subject: {$validated['subject']}\n\n{$validated['message']}",
            'source' => 'contact_form',
            'ip_address' => $request->ip(),
        ]);

        // Send email notification to admin
        try {
            Mail::to(config('mail.from.address', 'info@balirealtyhv.com'))
                ->send(new InquiryNotification($inquiry));
        } catch (\Exception $e) {
            \Log::error('Failed to send contact form notification: ' . $e->getMessage());
        }

        return back()->with('success', 'Thank you for contacting us. We will respond within 24 hours.');
    }

    public function about()
    {
        return view('frontend.contact.about');
    }
}
