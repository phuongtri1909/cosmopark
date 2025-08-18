<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\CategoryBlog;
use App\Models\BlogComment;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Hiển thị danh sách bài viết
     */
    public function index(Request $request)
    {
        $blogsQuery = Blog::with(['author', 'category'])
            ->where('is_active', true);

        // Search by input
        if ($request->has('search') && !empty($request->search)) {
            $keyword = $request->search;
            $blogsQuery->where(function($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('content', 'like', "%{$keyword}%");
            });
        }

        // Search by category
        if ($request->has('category') && !empty($request->category) && $request->category !== 'all') {
            $blogsQuery->where('category_blog_id', $request->category);
        }

        $latestNews = $blogsQuery->latest()->paginate(9)->withQueryString();

        $categories = CategoryBlog::withCount('blog')->orderBy('name')->get();
        $latestPost = Blog::where('is_active', true)
            ->latest()->first();

        return view('client.pages.blogs.index', compact('latestNews', 'categories', 'latestPost'));
    }

    /**
     * AJAX method để filter bài viết
     */
    public function filter(Request $request)
    {
        $blogsQuery = Blog::with(['author', 'category'])
            ->where('is_active', true);

        // Search by input
        if ($request->has('search') && !empty($request->search)) {
            $keyword = $request->search;
            $blogsQuery->where(function($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('content', 'like', "%{$keyword}%");
            });
        }

        // Search by category
        if ($request->has('category') && !empty($request->category) && $request->category !== 'all') {
            $blogsQuery->where('category_blog_id', $request->category);
        }

        // Lấy page từ request, mặc định là 1
        $page = $request->get('page', 1);

        // Paginate với page cụ thể
        $blogs = $blogsQuery->latest()->paginate(9, ['*'], 'page', $page);

        // Luôn trả về JSON response cho AJAX
        $html = view('components.news-list', compact('blogs'))->render();

        return response()->json([
            'html' => $html,
            'total' => $blogs->total(),
            'current_page' => $blogs->currentPage(),
            'last_page' => $blogs->lastPage(),
            'per_page' => $blogs->perPage()
        ]);
    }

    /**
     * Hiển thị chi tiết bài viết
     */
    public function show($slug)
    {
        $blog = Blog::with(['author', 'category'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Tăng lượt xem
        $blog->incrementViews();

        // Lấy bài viết liên quan
        $relatedPosts = Blog::with(['category'])
            ->where('id', '!=', $blog->id)
            ->where('is_active', true)
            ->where('category_blog_id', $blog->category_blog_id)
            ->latest()
            ->take(6)
            ->get();

        // Lấy danh mục và bài viết mới nhất cho sidebar
        $categories = CategoryBlog::withCount('blog')->orderBy('name')->get();
        $latestPosts = Blog::where('is_active', true)
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(5)
            ->get();

        return view('client.pages.blogs.show', compact(
            'blog',
            'relatedPosts',
            'categories',
            'latestPosts'
        ));
    }

    /**
     * Hiển thị danh sách bài viết theo danh mục
     */
    public function category($slug)
    {
        $category = CategoryBlog::where('slug', $slug)->firstOrFail();

        $blogs = Blog::with(['author', 'categories'])
            ->where('is_active', true)
            ->whereHas('categories', function ($q) use ($category) {
                $q->where('category_blogs.id', $category->id);
            })
            ->latest()
            ->paginate(6);

        // Lấy danh mục và bài viết mới nhất cho sidebar
        $categories = CategoryBlog::withCount('blogs')->orderBy('name')->get();
        $latestPosts = Blog::where('is_active', true)
            ->latest()
            ->take(5)
            ->get();

        return view('client.pages.blogs.index', compact('blogs', 'categories', 'latestPosts', 'category'));
    }
}
