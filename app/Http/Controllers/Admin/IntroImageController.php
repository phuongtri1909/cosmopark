<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IntroImage;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class IntroImageController extends Controller
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
        $introImages = IntroImage::ordered()->paginate(10);
        return view('admin.pages.intro-images.index', compact('introImages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->languages;
        return view('admin.pages.intro-images.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|accepted',
        ];
        
        foreach ($this->languages as $lang => $langName) {
            $rules["title.$lang"] = 'required|string|max:255';
            $rules["description.$lang"] = 'required|string|max:1000';
        }
        
        $messages = [
            'image.required' => 'Ảnh giới thiệu là bắt buộc.',
            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, webp.',
            'image.max' => 'Ảnh không được lớn hơn 5MB.',
            'title.vi.required' => 'Tiêu đề (VI) là bắt buộc.',
            'title.en.required' => 'Tiêu đề (EN) là bắt buộc.',
            'description.vi.required' => 'Mô tả (VI) là bắt buộc.',
            'description.en.required' => 'Mô tả (EN) là bắt buộc.',
        ];
        
        try {
            $validated = $request->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('IntroImage validation failed:', [
                'errors' => $e->errors()
            ]);
            throw $e;
        }
        
        try {
            $imagePath = null;
            
            if ($request->hasFile('image')) {
                $imagePath = ImageHelper::optimizeAndSave(
                    $request->file('image'),
                    'intro-images',
                    null,
                    95
                );
                Log::info('Image processed successfully:', ['path' => $imagePath]);
            }
            
            $isActive = $request->has('is_active');
            $sortOrder = $request->sort_order ?? 0;
            
            $introImage = IntroImage::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imagePath,
                'sort_order' => $sortOrder,
                'is_active' => $isActive,
            ]);
            
            return redirect()->route('admin.intro-images.index')
                ->with('success', 'Ảnh giới thiệu đã được tạo thành công.');
        } catch (\Exception $e) {
            Log::error('IntroImage creation failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Nếu có lỗi, xóa ảnh đã upload
            if (isset($imagePath) && $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IntroImage $introImage)
    {
        $languages = $this->languages;
        return view('admin.pages.intro-images.edit', compact('introImage', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IntroImage $introImage)
    {
        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|accepted',
        ];
        
        foreach ($this->languages as $lang => $langName) {
            $rules["title.$lang"] = 'required|string|max:255';
            $rules["description.$lang"] = 'required|string|max:1000';
        }
        
        $messages = [
            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, webp.',
            'image.max' => 'Ảnh không được lớn hơn 5MB.',
            'title.vi.required' => 'Tiêu đề (VI) là bắt buộc.',
            'title.en.required' => 'Tiêu đề (EN) là bắt buộc.',
            'description.vi.required' => 'Mô tả (VI) là bắt buộc.',
            'description.en.required' => 'Mô tả (EN) là bắt buộc.',
        ];
        
        $validated = $request->validate($rules, $messages);
        
        try {
            $oldImage = $introImage->image;
            $newImagePath = $oldImage;
            
            if ($request->hasFile('image')) {
                $newImagePath = ImageHelper::optimizeAndSave(
                    $request->file('image'),
                    'intro-images',
                    null,
                    95
                );
                
                // Xóa ảnh cũ nếu upload thành công
                if ($oldImage && $newImagePath !== $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            $introImage->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $newImagePath,
                'sort_order' => $request->sort_order ?? $introImage->sort_order,
                'is_active' => $request->has('is_active'),
            ]);
            
            return redirect()->route('admin.intro-images.index')
                ->with('success', 'Ảnh giới thiệu đã được cập nhật thành công.');
        } catch (\Exception $e) {
            // Nếu có lỗi, xóa ảnh mới đã upload
            if (isset($newImagePath) && $newImagePath !== $oldImage) {
                Storage::disk('public')->delete($newImagePath);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IntroImage $introImage)
    {
        try {
            if ($introImage->image) {
                Storage::disk('public')->delete($introImage->image);
            }
            
            $introImage->delete();
            
            return redirect()->route('admin.intro-images.index')
                ->with('success', 'Ảnh giới thiệu đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.intro-images.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
} 