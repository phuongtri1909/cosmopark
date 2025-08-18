<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\CategoryBlog;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryBlogController extends Controller
{
    protected $languages;

    public function __construct()
    {
        $this->languages = ['vi' => 'Tiếng Việt', 'en' => 'English'];
    }

    /**
     * Display a listing of categories
     */
    public function index()
    {
        $categories = CategoryBlog::withCount('blog')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.pages.category-blogs.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('admin.pages.category-blogs.create', ['languages' => $this->languages]);
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $rules = [];
        foreach ($this->languages as $lang => $langName) {
            $rules["name.$lang"] = 'required|string|max:255';
            $rules["description.$lang"] = 'nullable|string';
        }

        $messages = [
            'name.vi.required' => 'Tên danh mục (VI) không được để trống',
            'name.en.required' => 'Tên danh mục (EN) không được để trống',
            'name.vi.max' => 'Tên danh mục (VI) không được vượt quá 255 ký tự',
            'name.en.max' => 'Tên danh mục (EN) không được vượt quá 255 ký tự',
        ];
        $request->validate($rules, $messages);

        $slug = Str::slug($request->name['vi']);
        $originalSlug = $slug;
        $count = 1;
        while (CategoryBlog::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $categoryBlogData = [
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
        ];

        CategoryBlog::create($categoryBlogData);

        return redirect()->route('admin.category-blogs.index')
            ->with('success', 'Danh mục đã được tạo thành công!');
    }

    /**
     * Show the form for editing a category
     */
    public function edit(CategoryBlog $categoryBlog)
    {
        $categoryBlog->loadCount('blog');
        return view('admin.pages.category-blogs.edit', ['categoryBlog' => $categoryBlog], ['languages' => $this->languages]);
    }

    /**
     * Update a category
     */
    public function update(Request $request, CategoryBlog $categoryBlog)
    {
        try {
            $rules = [];
            foreach ($this->languages as $lang => $langName) {
                $rules["name.$lang"] = 'required|string|max:255';
                $rules["description.$lang"] = 'nullable|string';
            }

            $messages = [
                'name.vi.required' => 'Tên danh mục (VI) không được để trống',
                'name.en.required' => 'Tên danh mục (EN) không được để trống',
                'name.vi.max' => 'Tên danh mục (VI) không được vượt quá 255 ký tự',
                'name.en.max' => 'Tên danh mục (EN) không được vượt quá 255 ký tự',
            ];
            $request->validate($rules, $messages);

            $slug = $categoryBlog->slug;
            if ($request->name['vi'] !== $categoryBlog->getTranslation('name', 'vi')) {
                $slug = Str::slug($request->name['vi']);
                $originalSlug = $slug;
                $count = 1;
                while (CategoryBlog::where('slug', $slug)->where('id', '!=', $categoryBlog->id)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }
                $categoryBlog->slug = $slug;
            }

            $categoryBlogData = [
                'name' => $request->name,
                'slug' => $slug,
                'description' => $request->description,
            ];


            $categoryBlog->update($categoryBlogData);

        } catch (\Exception $e) {
            \Log::error('Lỗi khi cập nhật: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Lỗi khi cập nhật danh mục: ' . $e->getMessage()]);
        }

        return redirect()->route('admin.category-blogs.index')
            ->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    /**
     * Delete a category
     */
    public function destroy(CategoryBlog $categoryBlog)
    {
        // Detach all blogs
        $categoryBlog->blogs()->detach();

        // Delete the category
        $categoryBlog->delete();

        return redirect()->route('admin.category-blogs.index')
            ->with('success', 'Danh mục đã được xóa thành công!');
    }
}
