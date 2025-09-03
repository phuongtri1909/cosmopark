<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    protected $languages;

    public function __construct()
    {
        $this->languages = ['vi' => 'Tiếng Việt', 'en' => 'English'];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::ordered()->paginate(10);
        return view('admin.pages.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->languages;
        return view('admin.pages.projects.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'slug' => 'required|string|max:255|unique:projects,slug',
            'number' => 'required|string|max:50',
            'unit' => 'required|string|max:50',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'reverse_row' => 'sometimes|accepted',
            'reverse_col' => 'sometimes|accepted',
            'reverse_image' => 'sometimes|accepted',
            'show_button' => 'sometimes|accepted',
            'button_url' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|accepted',
        ];
        
        foreach ($this->languages as $lang => $langName) {
            $rules["title.$lang"] = 'required|string|max:255';
            $rules["description.$lang"] = 'required|string|max:1000';
            if ($request->has('subtitle')) {
                $rules["subtitle.$lang"] = 'nullable|string|max:255';
            }
            if ($request->has('show_button') && $request->show_button) {
                $rules["button_text.$lang"] = 'required|string|max:255';
            }
        }
        
        $messages = [
            'slug.required' => 'Slug là bắt buộc.',
            'slug.unique' => 'Slug đã tồn tại.',
            'title.vi.required' => 'Tiêu đề (VI) là bắt buộc.',
            'title.en.required' => 'Tiêu đề (EN) là bắt buộc.',
            'description.vi.required' => 'Mô tả (VI) là bắt buộc.',
            'description.en.required' => 'Mô tả (EN) là bắt buộc.',
            'hero_image.image' => 'File phải là hình ảnh.',
            'hero_image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp.',
            'hero_image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'button_url.url' => 'URL không hợp lệ.',
        ];
        
        try {
            $validated = $request->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Project validation failed:', [
                'errors' => $e->errors()
            ]);
            throw $e;
        }
        
        try {
            $data = [
                'slug' => $request->slug,
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'number' => $request->number,
                'unit' => $request->unit,
                'reverse_row' => $request->has('reverse_row'),
                'reverse_col' => $request->has('reverse_col'),
                'reverse_image' => $request->has('reverse_image'),
                'show_button' => $request->has('show_button'),
                'button_text' => $request->button_text,
                'button_url' => $request->button_url,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->has('is_active'),
            ];

            // Xử lý upload hero image
            if ($request->hasFile('hero_image')) {
                $imagePath = $request->file('hero_image')->store('projects', 'public');
                $data['hero_image'] = $imagePath;
            }
            
            $project = Project::create($data);
            
            Log::info('Project created successfully:', ['id' => $project->id]);
            
            return redirect()->route('admin.projects.index')
                ->with('success', 'Dự án đã được tạo thành công.');
        } catch (\Exception $e) {
            Log::error('Project creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $languages = $this->languages;
        return view('admin.pages.projects.edit', compact('project', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $rules = [
            'slug' => 'required|string|max:255|unique:projects,slug,' . $project->id,
            'number' => 'required|string|max:50',
            'unit' => 'required|string|max:50',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'reverse_row' => 'sometimes|accepted',
            'reverse_col' => 'sometimes|accepted',
            'reverse_image' => 'sometimes|accepted',
            'show_button' => 'sometimes|accepted',
            'button_url' => 'nullable|url|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|accepted',
        ];
        
        foreach ($this->languages as $lang => $langName) {
            $rules["title.$lang"] = 'required|string|max:255';
            $rules["description.$lang"] = 'required|string|max:1000';
            if ($request->has('subtitle')) {
                $rules["subtitle.$lang"] = 'nullable|string|max:255';
            }
            if ($request->has('show_button') && $request->show_button) {
                $rules["button_text.$lang"] = 'required|string|max:255';
            }
        }
        
        $messages = [
            'slug.required' => 'Slug là bắt buộc.',
            'slug.unique' => 'Slug đã tồn tại.',
            'title.vi.required' => 'Tiêu đề (VI) là bắt buộc.',
            'title.en.required' => 'Tiêu đề (EN) là bắt buộc.',
            'description.vi.required' => 'Mô tả (VI) là bắt buộc.',
            'description.en.required' => 'Mô tả (EN) là bắt buộc.',
            'hero_image.image' => 'File phải là hình ảnh.',
            'hero_image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp.',
            'hero_image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'button_url.url' => 'URL không hợp lệ.',
        ];
        
        $validated = $request->validate($rules, $messages);
        
        try {
            $data = [
                'slug' => $request->slug,
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'number' => $request->number,
                'unit' => $request->unit,
                'reverse_row' => $request->has('reverse_row'),
                'reverse_col' => $request->has('reverse_col'),
                'reverse_image' => $request->has('reverse_image'),
                'show_button' => $request->has('show_button'),
                'button_text' => $request->button_text,
                'button_url' => $request->button_url,
                'sort_order' => $request->sort_order ?? $project->sort_order,
                'is_active' => $request->has('is_active'),
            ];

            // Xử lý upload hero image mới
            if ($request->hasFile('hero_image')) {
                // Xóa hero image cũ nếu có
                if ($project->hero_image) {
                    Storage::disk('public')->delete($project->hero_image);
                }
                
                $imagePath = $request->file('hero_image')->store('projects', 'public');
                $data['hero_image'] = $imagePath;
            }
            
            $project->update($data);
            
            return redirect()->route('admin.projects.index')
                ->with('success', 'Dự án đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            // Xóa hero image nếu có
            if ($project->hero_image) {
                Storage::disk('public')->delete($project->hero_image);
            }
            
            $project->delete();
            
            return redirect()->route('admin.projects.index')
                ->with('success', 'Dự án đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.projects.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
} 