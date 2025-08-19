<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;

class ContactSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactSubmission::query()->latest();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $submissions = $query->paginate(12)->withQueryString();

        return view('admin.pages.contacts.index', compact('submissions'));
    }

    public function show(ContactSubmission $contact)
    {
        return view('admin.pages.contacts.show', compact('contact'));
    }

    public function destroy(ContactSubmission $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Xóa thành công');
    }
}


