<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Industry;
use App\Models\BlogComment;
use App\Models\CategoryBlog;
use App\Models\Project;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use App\Models\SlideLocation;

class ProjectController extends Controller
{

    /**
     * Hiển thị chi tiết dự án
     */
    public function show($slug)
    {

        $project = Project::findBySlug($slug);

        $slideLocations = SlideLocation::getActiveSlides();
        $industries = Industry::active()->ordered()->get();
        
        // Generate dynamic SEO for project
        $baseSeo = SeoSetting::getByPageKey('projects');
        $seoData = SeoSetting::getProjectSeo($project, $baseSeo);
        
        return view('client.pages.project', compact('project', 'slideLocations', 'industries', 'seoData'));
    }

}
