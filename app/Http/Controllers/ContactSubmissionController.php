<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Models\SMTPSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactSubmissionController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $submission = ContactSubmission::create([
            'full_name' => $request->input('full_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'source_url' => $request->headers->get('referer') ?? url()->previous(),
        ]);

        // Notify admin by email if admin_email configured
        $smtp = SMTPSetting::first();
        if ($smtp && !empty($smtp->admin_email)) {
            try {
                Mail::raw(
                    "New contact submission:\nName: {$submission->full_name}\nPhone: {$submission->phone}\nEmail: {$submission->email}\nPage: {$submission->source_url}",
                    function ($message) use ($smtp) {
                        $message->to($smtp->admin_email)
                            ->subject('New contact submission');
                    }
                );
            } catch (\Throwable $e) {
                // log and continue
                \Log::error('Failed sending contact notification', ['error' => $e->getMessage()]);
            }
        }

        if($request->ajax()){
        return response()->json([
                'success' => true,
            ]);
        }

        return redirect()->back()->with('success', __('Thank you for your message. We will get back to you soon.'));
    }
}


