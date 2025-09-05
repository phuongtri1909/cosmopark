<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BannerPage;

class ContactController extends Controller
{
    public function index()
    {
        // Load banner page data for contact
        $bannerPage = BannerPage::getBannerForPage('contact');
        
        return view('client.pages.contact', compact('bannerPage'));
    }
}
