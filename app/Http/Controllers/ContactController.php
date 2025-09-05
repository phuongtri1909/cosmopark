<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BannerPage;
use App\Models\SeoSetting;

class ContactController extends Controller
{
    public function index()
    {
        // Load banner page data for contact
        $bannerPage = BannerPage::getBannerForPage('contact');
        $seoSetting = SeoSetting::getByPageKey('contact');
        
        return view('client.pages.contact', compact('bannerPage', 'seoSetting'));
    }
}
