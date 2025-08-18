<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Blog;
use App\Models\CategoryBlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{

    protected $languages;

    public function __construct()
    {
        $this->languages = ['vi' => 'Tiếng Việt', 'en' => 'English'];
    }

    /**
     * Hiển thị danh sách bài viết
     */
    public function index(Request $request)
    {
        $query = Blog::with(['author', 'category']);

        // Filter theo danh mục
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('category_blogs.id', $request->category_id);
            });
        }

        // Filter theo tiêu đề
        if ($request->has('title') && !empty($request->title)) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Filter theo trạng thái
        if ($request->has('status') && !empty($request->status)) {
            if ($request->status == 'active') {
                $query->where('is_active', true);
            } elseif ($request->status == 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status == 'featured') {
                $query->where('is_featured', true);
            }
        }

        // Sắp xếp
        $query->orderBy('created_at', 'desc');

        // Lấy danh sách bài viết
        $blogs = $query->paginate(10);

        // Lấy danh sách danh mục cho bộ lọc
        $categories = CategoryBlog::orderBy('name')->get();

        return view('admin.pages.blogs.index', compact('blogs', 'categories'));
    }

    /**
     * Hiển thị form tạo bài viết mới
     */
    public function create()
    {
        $categories = CategoryBlog::orderBy('name')->get();
        $languages = $this->languages;
        return view('admin.pages.blogs.create', compact('categories', 'languages'));
    }

    /**
     * Lưu bài viết mới vào database
     */
    public function store(Request $request)
    {
        $rules = [
            'category_blog_id' => 'required|exists:category_blogs,id',
            'avatar' => 'required|image|max:2048',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'author_name' => 'nullable|string|max:255',
        ];
        foreach ($this->languages as $lang => $langName) {
            $rules["title.$lang"] = 'required|string|max:255';
            $rules["content.$lang"] = 'required|string';
        }
        $messages = [
            'title.vi.required' => 'Tiêu đề (VI) là bắt buộc.',
            'title.en.required' => 'Tiêu đề (EN) là bắt buộc.',
            'content.vi.required' => 'Nội dung (VI) là bắt buộc.',
            'content.en.required' => 'Nội dung (EN) là bắt buộc.',
            'category_blog_id.required' => 'Vui lòng chọn danh mục.',
            'category_blog_id.exists' => 'Danh mục không hợp lệ.',
            'avatar.required' => 'Hình ảnh đại diện là bắt buộc.',
            'avatar.image' => 'Hình ảnh đại diện phải là một tệp hình ảnh hợp lệ.',
            'avatar.max' => 'Kích thước hình ảnh đại diện không được vượt quá 2MB.',
        ];
        $validated = $request->validate($rules, $messages);

        // Xử lý slug
        $slug = Str::slug($validated['title']['vi']);
        $originalSlug = $slug;
        $count = 1;

        while (Blog::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        // Xử lý hình ảnh
        $imagePath = null;
        if ($request->hasFile('avatar')) {
            $imagePath = $request->file('avatar')->store('blogs', 'public');
        }

        // Tạo bài viết mới
        $blog = Blog::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'image' => $imagePath,
            'category_blog_id' => $request->category_blog_id,
            'is_active' => $request->has('is_active'),
            'is_featured' => $request->has('is_featured'),
            'author_id' => auth()->id(),
            'author_name' => $request->author_name,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Bài viết đã được tạo thành công!',
                'redirect' => route('admin.blogs.index')
            ]);
        }

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Bài viết đã được tạo thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa bài viết
     */
    public function edit(Blog $blog)
    {
        $categories = CategoryBlog::orderBy('name')->get();
        $languages = $this->languages;
        return view('admin.pages.blogs.edit', compact('blog', 'categories', 'languages'));
    }

    /**
     * Cập nhật bài viết
     */
    public function update(Request $request, Blog $blog)
    {
        $languages = ['vi', 'en'];
        $rules = [
            'category_blog_id' => 'required|exists:category_blogs,id',
            'avatar' => 'sometimes|nullable|image|max:2048',
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'remove_avatar' => 'sometimes|boolean',
            'author_name' => 'nullable|string|max:255',
        ];
        foreach ($languages as $lang) {
            $rules["title.$lang"] = 'required|string|max:255';
            $rules["content.$lang"] = 'required|string';
        }
        $messages = [
            'title.vi.required' => 'Tiêu đề (VI) là bắt buộc.',
            'title.en.required' => 'Tiêu đề (EN) là bắt buộc.',
            'content.vi.required' => 'Nội dung (VI) là bắt buộc.',
            'content.en.required' => 'Nội dung (EN) là bắt buộc.',
            'category_blog_id.required' => 'Vui lòng chọn danh mục.',
            'category_blog_id.exists' => 'Danh mục không hợp lệ.',
            'avatar.image' => 'Hình ảnh đại diện phải là một tệp hình ảnh hợp lệ.',
            'avatar.max' => 'Kích thước hình ảnh đại diện không được vượt quá 2MB.',
        ];
        $validated = $request->validate($rules, $messages);

        // Xử lý slug nếu tiêu đề tiếng Việt thay đổi
        if ($request->title['vi'] !== $blog->getTranslation('title', 'vi')) {
            $slug = Str::slug($request->title['vi']);
            $originalSlug = $slug;
            $count = 1;
            while (Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $blog->slug = $slug;
        }

        // Xử lý hình ảnh
        $imagePath = $blog->image;
        if ($request->has('remove_avatar') && $request->remove_avatar == 1) {
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }
            $imagePath = null;
        }
        if ($request->hasFile('avatar')) {
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }
            $imagePath = $request->file('avatar')->store('blogs', 'public');
        }

        $blog->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'category_blog_id' => $request->category_blog_id,
            'is_active' => $request->has('is_active'),
            'is_featured' => $request->has('is_featured'),
            'author_id' => auth()->id(),
            'author_name' => $request->author_name,
        ]);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Bài viết đã được cập nhật thành công!');
    }

    /**
     * Xóa bài viết
     */
    public function destroy(Blog $blog)
    {
        // Xóa hình ảnh nếu có
        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Bài viết đã được xóa thành công!');
    }

    /**
     * Upload hình ảnh từ CKEditor
     */
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $fileName = $request->file('upload')->store('blogs/content', 'public');
            $url = asset('storage/' . $fileName);

            return response()->json([
                'uploaded' => 1,
                'fileName' => basename($fileName),
                'url' => $url
            ]);
        }

        return response()->json([
            'uploaded' => 0,
            'error' => [
                'message' => 'Không thể tải lên hình ảnh.'
            ]
        ]);
    }
}
