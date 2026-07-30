<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class ContactController extends Controller
{
    /**
     * Show the contact form page.
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        return view('contact_us.create'); // اسم ملف الـ blade الذي أنشأناه
    }

    /**
     * Handle the submission of the contact form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendEmail(Request $request)
    {
        // 1. Validate the form data
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // 2. Prepare the recipient email (البريد الذي سيستقبل الرسائل)
        $recipientEmail = 'your-target-email@example.com'; // **إستبدل هذا بالبريد الإلكتروني الذي تريد استقبال الرسائل عليه**

        try {
            // 3. Send the email
            Mail::to($recipientEmail)->send(new ContactMessage($validatedData));

            // 4. Redirect with a success message
            return redirect()->route('contact.form')->with('success', 'Your message has been sent successfully! We will get back to you soon.');

        } catch (\Exception $e) {
            // 5. Handle mail sending errors
            \Log::error('Mail sending error: ' . $e->getMessage());
            return redirect()->route('contact.form')->withInput()->withErrors(['email_error' => 'There was an issue sending your message. Please try again later or contact us directly.']);
        }
    }
}