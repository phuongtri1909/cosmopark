<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\ImageHome;
use App\Models\ImageHomeSub;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ImageHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $imageHomes = ImageHome::with('subImages')
            ->orderBy('sort_order', 'asc')
            ->paginate(10);
            
        return view('admin.pages.image-homes.index', compact('imageHomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.image-homes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'main_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp',
            'title' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
            'sub_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'sub_sort_orders.*' => 'nullable|integer|min:0',
        ],[
            'main_image.required' => 'Hình ảnh chính là bắt buộc',
            'main_image.image' => 'Hình ảnh chính phải là định dạng ảnh',
            'main_image.mimes' => 'Hình ảnh chính phải là định dạng jpeg, png, jpg, gif, webp',
            'title.required' => 'Tiêu đề là bắt buộc',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'sub_images.*.image' => 'Hình ảnh phụ phải là định dạng ảnh',
            'sub_images.*.mimes' => 'Hình ảnh phụ phải là định dạng jpeg, png, jpg, gif, webp',
        ]);
        
        try {
            $mainImagePath = null;
            if ($request->hasFile('main_image')) {
                $mainImagePath = ImageHelper::optimizeAndSave(
                    $request->file('main_image'),
                    'image-homes',
                    1200,
                    95
                );
            }
            
            $validated['main_image'] = $mainImagePath;
            $validated['is_active'] = $request->has('is_active');
            
            $imageHome = ImageHome::create($validated);
            
            // Handle sub images
            if ($request->hasFile('sub_images')) {
                foreach ($request->file('sub_images') as $index => $subImage) {
                    if ($subImage) {
                        $subImagePath = ImageHelper::optimizeAndSave(
                            $subImage,
                            'image-homes/sub',
                            800,
                            90
                        );
                        
                        $subSortOrder = (int)$request->input("sub_sort_orders.{$index}", $index);
                        
                        ImageHomeSub::create([
                            'image_home_id' => $imageHome->id,
                            'sub_image' => $subImagePath,
                            'sort_order' => $subSortOrder
                        ]);
                    }
                }
            }
            
            return redirect()->route('admin.image-homes.index')
                ->with('success', 'Hình ảnh trang chủ đã được tạo thành công.');
        } catch (\Exception $e) {
            if ($mainImagePath) {
                ImageHelper::delete($mainImagePath);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ImageHome $imageHome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImageHome $imageHome)
    {
        // Load subImages with default ordering from model
        $imageHome->load('subImages');
        return view('admin.pages.image-homes.edit', compact('imageHome'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImageHome $imageHome)
    {
        // Debug: Log request data before validation
        Log::info('Request Data Before Validation:', $request->all());
        Log::info('Files in Request:', $request->allFiles());
        
        try {
            Log::info('Starting validation with rules:', [
                'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'title' => 'required|string|max:255',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'sometimes|boolean',
                'sub_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'sub_sort_orders.*' => 'nullable|integer|min:0',
                'existing_sub_images.*' => 'nullable|integer',
                'delete_sub_images.*' => 'nullable|integer',
            ]);
            
            $validated = $request->validate([
                'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'title' => 'required|string|max:255',
                'sort_order' => 'nullable|integer|min:0',
                'is_active' => 'sometimes|boolean',
                'sub_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
                'sub_sort_orders.*' => 'nullable|integer|min:0',
                'existing_sub_images.*' => 'nullable|integer',
                'delete_sub_images.*' => 'nullable|integer',
            ],[
                'main_image.image' => 'Hình ảnh chính phải là định dạng ảnh',
                'main_image.mimes' => 'Hình ảnh chính phải là định dạng jpeg, png, jpg, gif, webp',
                'title.required' => 'Tiêu đề là bắt buộc',
                'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
                'sub_images.*.image' => 'Hình ảnh phụ phải là định dạng ảnh',
                'sub_images.*.mimes' => 'Hình ảnh phụ phải là định dạng jpeg, png, jpg, gif, webp',
            ]);
            
            // Debug: Log validation result
            Log::info('Validation Result:', $validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log validation errors
            Log::error('Validation Errors:', $e->errors());
            Log::error('Validation Failed for ImageHome Update');
            
            // Re-throw the exception to show validation errors to user
            throw $e;
        }
        
        try {
            // Prepare update data
            $updateData = [];
            
            // Handle main image upload
            if ($request->hasFile('main_image')) {
                Log::info('Main image file detected:', [
                    'original_name' => $request->file('main_image')->getClientOriginalName(),
                    'size' => $request->file('main_image')->getSize(),
                    'mime_type' => $request->file('main_image')->getMimeType(),
                    'is_valid' => $request->file('main_image')->isValid(),
                    'error' => $request->file('main_image')->getError()
                ]);
                
                $oldMainImagePath = $imageHome->main_image;
                
                try {
                    $mainImagePath = ImageHelper::optimizeAndSave(
                        $request->file('main_image'),
                        'image-homes',
                        1200,
                        90 
                    );
                    
                    Log::info('New main image path:', ['path' => $mainImagePath]);
                    $updateData['main_image'] = $mainImagePath;
                } catch (\Exception $e) {
                    Log::error('Error saving main image:', $e->getMessage());
                    throw $e;
                }
            } else {
                Log::info('No main image file uploaded');
            }
            
            // Add other fields to update data
            Log::info('Title from request:', ['title' => $request->input('title')]);
            Log::info('Sort order from request:', ['sort_order' => $request->input('sort_order')]);
            Log::info('Is active from request:', ['is_active' => $request->has('is_active')]);
            
            if (isset($validated['title'])) {
                $updateData['title'] = $validated['title'];
                Log::info('Title added to update data:', ['title' => $validated['title']]);
            }
            if (isset($validated['sort_order'])) {
                $updateData['sort_order'] = $validated['sort_order'];
                Log::info('Sort order added to update data:', ['sort_order' => $validated['sort_order']]);
            }
            $updateData['is_active'] = $request->has('is_active');
            Log::info('Is active added to update data:', ['is_active' => $request->has('is_active')]);
            
            // Debug: Log what's being updated
            Log::info('ImageHome Update Data:', $updateData);
            Log::info('Request Data:', $request->all());
            
            // Only update if there's data to update
            if (!empty($updateData)) {
                $imageHome->update($updateData);
            }
            
            // Handle existing sub images updates
            if ($request->has('existing_sub_images')) {
                Log::info('Processing existing sub images:', $request->input('existing_sub_images'));
                foreach ($request->input('existing_sub_images', []) as $subImageId => $sortOrder) {
                    $subImage = ImageHomeSub::find($subImageId);
                    if ($subImage && $subImage->image_home_id == $imageHome->id) {
                        Log::info("Updating sub image", ['id' => $subImageId, 'sort_order' => $sortOrder]);
                        $subImage->update(['sort_order' => (int)$sortOrder]);
                    } else {
                        Log::warning("Sub image not found or doesn't belong to ImageHome", ['sub_image_id' => $subImageId, 'image_home_id' => $imageHome->id]);
                    }
                }
            }
            
            // Handle new sub images
            if ($request->hasFile('sub_images')) {
                foreach ($request->file('sub_images') as $index => $subImage) {
                    if ($subImage) {
                        $subImagePath = ImageHelper::optimizeAndSave(
                            $subImage,
                            'image-homes/sub',
                            800,
                            90
                        );
                        
                        $subSortOrder = (int)$request->input("sub_sort_orders.{$index}", $index);
                        
                        ImageHomeSub::create([
                            'image_home_id' => $imageHome->id,
                            'sub_image' => $subImagePath,
                            'sort_order' => $subSortOrder
                        ]);
                    }
                }
            }
            
            // Handle sub image deletions
            if ($request->has('delete_sub_images')) {
                foreach ($request->input('delete_sub_images', []) as $subImageId) {
                    $subImage = ImageHomeSub::find($subImageId);
                    if ($subImage && $subImage->image_home_id == $imageHome->id) {
                        $oldSubImagePath = $subImage->sub_image;
                        $subImage->delete();
                        if ($oldSubImagePath) {
                            ImageHelper::delete($oldSubImagePath);
                        }
                    }
                }
            }
            
            if (isset($oldMainImagePath)) {
                ImageHelper::delete($oldMainImagePath);
            }
            
            return redirect()->route('admin.image-homes.index')
                ->with('success', 'Hình ảnh trang chủ đã được cập nhật thành công.');
        } catch (\Exception $e) {
            if (isset($mainImagePath)) {
                ImageHelper::delete($mainImagePath);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImageHome $imageHome)
    {
        try {
            $oldMainImagePath = $imageHome->main_image;
            
            // Delete sub images first
            foreach ($imageHome->subImages as $subImage) {
                $oldSubImagePath = $subImage->sub_image;
                $subImage->delete();
                if ($oldSubImagePath) {
                    ImageHelper::delete($oldSubImagePath);
                }
            }
            
            $imageHome->delete();
            
            if ($oldMainImagePath) {
                ImageHelper::delete($oldMainImagePath);
            }
            
            return redirect()->route('admin.image-homes.index')
                ->with('success', 'Hình ảnh trang chủ đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.image-homes.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
} 