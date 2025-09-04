<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Gallery;
use App\Models\Project;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galleries = Gallery::with(['project' => function($query) {
                $query->select('id', 'title', 'slug');
            }])
            ->orderBy('sort_order', 'asc')
            ->paginate(10);
            
        return view('admin.pages.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::active()
            ->ordered()
            ->select('id', 'title', 'slug')
            ->get()
            ->map(function ($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->getTranslation('title', app()->getLocale()),
                    'slug' => $project->slug
                ];
            });
        return view('admin.pages.galleries.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'image_1' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'image_5' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'title' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ],[
            'project_id.required' => 'Dự án là bắt buộc',
            'project_id.exists' => 'Dự án không tồn tại',
            'image_1.required' => 'Hình ảnh chính là bắt buộc',
            'image_1.image' => 'Hình ảnh chính phải là định dạng ảnh',
            'image_1.mimes' => 'Hình ảnh chính phải là định dạng jpeg, png, jpg, gif, webp',
            'title.required' => 'Tiêu đề là bắt buộc',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'image_2.image' => 'Hình ảnh 2 phải là định dạng ảnh',
            'image_2.mimes' => 'Hình ảnh 2 phải là định dạng jpeg, png, jpg, gif, webp',
            'image_3.image' => 'Hình ảnh 3 phải là định dạng ảnh',
            'image_3.mimes' => 'Hình ảnh 3 phải là định dạng jpeg, png, jpg, gif, webp',
            'image_4.image' => 'Hình ảnh 4 phải là định dạng ảnh',
            'image_4.mimes' => 'Hình ảnh 4 phải là định dạng jpeg, png, jpg, gif, webp',
            'image_5.image' => 'Hình ảnh 5 phải là định dạng ảnh',
            'image_5.mimes' => 'Hình ảnh 5 phải là định dạng jpeg, png, jpg, gif, webp',
        ]);
        
        try {
            $imagePaths = [];
            
            // Handle image uploads
            for ($i = 1; $i <= 5; $i++) {
                $imageField = "image_{$i}";
                if ($request->hasFile($imageField)) {
                    $imagePaths[$imageField] = ImageHelper::optimizeAndSave(
                        $request->file($imageField),
                        'galleries',
                        1200,
                        80
                    );
                }
            }
            
            $validated = array_merge($validated, $imagePaths);
            $validated['is_active'] = $request->has('is_active');
            
            $gallery = Gallery::create($validated);
            
            return redirect()->route('admin.galleries.index')
                ->with('success', 'Gallery đã được tạo thành công.');
        } catch (\Exception $e) {
            // Clean up uploaded images on error
            foreach ($imagePaths as $path) {
                if ($path) {
                    ImageHelper::delete($path);
                }
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        $projects = Project::active()
            ->ordered()
            ->select('id', 'title', 'slug')
            ->get()
            ->map(function ($project) {
                return [
                    'id' => $project->id,
                    'title' => $project->getTranslation('title', app()->getLocale()),
                    'slug' => $project->slug
                ];
            });
        return view('admin.pages.galleries.edit', compact('gallery', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        try {
            $validated = $request->validate([
                'project_id' => 'required|exists:projects,id',
                'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'image_5' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'title' => 'required|string|max:255',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'sometimes|boolean',
            ],[
                'project_id.required' => 'Dự án là bắt buộc',
                'project_id.exists' => 'Dự án không tồn tại',
                'image_1.image' => 'Hình ảnh 1 phải là định dạng ảnh',
                'image_1.mimes' => 'Hình ảnh 1 phải là định dạng jpeg, png, jpg, gif, webp',
                'title.required' => 'Tiêu đề là bắt buộc',
                'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
                'image_2.image' => 'Hình ảnh 2 phải là định dạng ảnh',
                'image_2.mimes' => 'Hình ảnh 2 phải là định dạng jpeg, png, jpg, gif, webp',
                'image_3.image' => 'Hình ảnh 3 phải là định dạng ảnh',
                'image_3.mimes' => 'Hình ảnh 3 phải là định dạng jpeg, png, jpg, gif, webp',
                'image_4.image' => 'Hình ảnh 4 phải là định dạng ảnh',
                'image_4.mimes' => 'Hình ảnh 4 phải là định dạng jpeg, png, jpg, gif, webp',
                'image_5.image' => 'Hình ảnh 5 phải là định dạng ảnh',
                'image_5.mimes' => 'Hình ảnh 5 phải là định dạng jpeg, png, jpg, gif, webp',
            ]);
            
            $updateData = [];
            $oldImagePaths = [];
            
            // Handle image uploads
            for ($i = 1; $i <= 5; $i++) {
                $imageField = "image_{$i}";
                if ($request->hasFile($imageField)) {
                    $oldImagePaths[] = $gallery->$imageField;
                    
                    $updateData[$imageField] = ImageHelper::optimizeAndSave(
                        $request->file($imageField),
                        'galleries',
                        1200,
                        80
                    );
                }
            }
            
            // Add other fields to update data
            if (isset($validated['project_id'])) {
                $updateData['project_id'] = $validated['project_id'];
            }
            if (isset($validated['title'])) {
                $updateData['title'] = $validated['title'];
            }
            if (isset($validated['sort_order'])) {
                $updateData['sort_order'] = $validated['sort_order'];
            }
            $updateData['is_active'] = $request->has('is_active');
            
            // Only update if there's data to update
            if (!empty($updateData)) {
                $gallery->update($updateData);
            }
            
            // Clean up old images
            foreach ($oldImagePaths as $oldPath) {
                if ($oldPath) {
                    ImageHelper::delete($oldPath);
                }
            }
            
            return redirect()->route('admin.galleries.index')
                ->with('success', 'Gallery đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        try {
            $oldImagePaths = [];
            
            // Collect all image paths
            for ($i = 1; $i <= 5; $i++) {
                $imageField = "image_{$i}";
                if ($gallery->$imageField) {
                    $oldImagePaths[] = $gallery->$imageField;
                }
            }
            
            $gallery->delete();
            
            // Clean up images
            foreach ($oldImagePaths as $oldPath) {
                if ($oldPath) {
                    ImageHelper::delete($oldPath);
                }
            }
            
            return redirect()->route('admin.galleries.index')
                ->with('success', 'Gallery đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.galleries.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}