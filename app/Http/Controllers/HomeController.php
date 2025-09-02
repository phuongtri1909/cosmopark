<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Product;
use App\Models\BannerHome;
use App\Models\ImageHome;
use App\Models\DressStyle;
use App\Models\ProductView;
use App\Models\ReviewRating;
use Illuminate\Http\Request;
use App\Models\FeatureSection;
use App\Models\ProductVariant;
use App\Models\GeneralIntroduction;
use App\Models\IntroFeature;
use App\Models\IntroLocation;
use App\Models\SlideLocation;
use App\Models\IntroImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Load 3 tin tức mới nhất
        $latestNews = Blog::with(['author', 'category'])
            ->where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        $bannerHomes = BannerHome::active()->ordered()->get();
        
        // Load image homes for the image-home component
        $imageHomes = ImageHome::with('subImages')
            ->active()
            ->ordered()
            ->get();
        
        // Load general introduction and features
        $generalIntroduction = GeneralIntroduction::getActive();
        $introFeatures = IntroFeature::active()->ordered()->get();
        $introLocation = IntroLocation::getActive();
        $slideLocations = SlideLocation::getActiveSlides();
        $introImage = IntroImage::getActive();

        return view('client.pages.home', compact('latestNews', 'bannerHomes', 'imageHomes', 'generalIntroduction', 'introFeatures', 'introLocation', 'slideLocations', 'introImage'));
    }

    public function about()
    {
        $introFeatures = IntroFeature::active()->ordered()->get();
        $generalIntroduction = GeneralIntroduction::getActive();
        return view('client.pages.about', compact('introFeatures', 'generalIntroduction'));
    }
}
