<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\CategoryBlog;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    /**
     * Hiển thị chi tiết dự án
     */
    public function show($slug)
    {


        return view('client.pages.project', compact('slug'));
    }

}
