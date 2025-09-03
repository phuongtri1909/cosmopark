<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Industry;
use App\Models\BlogComment;
use App\Models\CategoryBlog;
use App\Models\Project;
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
        
        return view('client.pages.project', compact('project', 'slideLocations', 'industries'));
    }

}
