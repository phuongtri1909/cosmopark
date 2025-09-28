<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Feature;
use App\Models\Product;
use App\Models\Industry;
use App\Models\ImageHome;
use App\Models\BannerHome;
use App\Models\BannerPage;
use App\Models\DressStyle;
use App\Models\IntroImage;
use App\Models\ProductView;
use App\Models\IntroFeature;
use App\Models\ReviewRating;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use App\Models\IntroLocation;
use App\Models\SlideLocation;
use App\Models\VisionMission;
use App\Models\FeatureSection;
use App\Models\ProductVariant;
use App\Models\GeneralIntroduction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $latestNews = Blog::with(['author', 'category'])
            ->where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        $bannerHomes = BannerHome::active()->ordered()->get();
        
        $imageHomes = ImageHome::with('subImages')
            ->active()
            ->ordered()
            ->get();
        
        $generalIntroduction = GeneralIntroduction::getActive();
        $introFeatures = IntroFeature::active()->ordered()->get();
        $introLocation = IntroLocation::getActive();
        $introImage = IntroImage::getActive();
        $visionMission = VisionMission::getActiveVisionMission();
        $seoSetting = SeoSetting::getByPageKey('home');

        return view('client.pages.home', compact('latestNews', 'bannerHomes', 'imageHomes', 'generalIntroduction', 'introFeatures', 'introLocation', 'introImage', 'visionMission', 'seoSetting'));
    }

    public function about()
    {
        $introFeatures = IntroFeature::active()->ordered()->get();
        $generalIntroduction = GeneralIntroduction::getActive();
        $visionMission = VisionMission::getActiveVisionMission();
        $features = Feature::getActiveFeatures();
        
        $imageHomes = ImageHome::with('subImages')
            ->active()
            ->ordered()
            ->get();
        $introImage = IntroImage::getActive();
        $industries = Industry::active()->ordered()->get();

        $bannerPage = BannerPage::getBannerForPage('about');
        $seoSetting = SeoSetting::getByPageKey('about');
        return view('client.pages.about', compact('introFeatures', 'generalIntroduction', 'introImage', 'visionMission', 'features', 'imageHomes', 'industries', 'bannerPage', 'seoSetting'));
    }
}
