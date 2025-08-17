<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Product;
use App\Models\DressStyle;
use App\Models\FeatureSection;
use App\Models\ProductView;
use App\Models\ReviewRating;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        return view('client.pages.home', []);
    }

    public function about()
    {
        return view('client.pages.about');
    }
}
