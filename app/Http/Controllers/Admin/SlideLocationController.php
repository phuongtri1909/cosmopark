<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SlideLocation;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slideLocations = SlideLocation::ordered()->paginate(10);
        return view('admin.pages.slide-locations.index', compact('slideLocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.slide-locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ];
        
        $messages = [
            'image.required' => 'Ảnh slide là bắt buộc.',
            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, webp.',
            'image.max' => 'Ảnh không được lớn hơn 5MB.',
        ];
        
        $validated = $request->validate($rules, $messages);
        
        try {
            $imagePath = null;
            
            if ($request->hasFile('image')) {
                $imagePath = ImageHelper::optimizeAndSave(
                    $request->file('image'),
                    'slide-locations',
                    null,
                    95
                );
            }
            
            $slideLocation = SlideLocation::create([
                'image' => $imagePath,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->has('is_active'),
            ]);
            
            return redirect()->route('admin.slide-locations.index')
                ->with('success', 'Slide vị trí đã được tạo thành công.');
        } catch (\Exception $e) {
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
    public function edit(SlideLocation $slideLocation)
    {
        return view('admin.pages.slide-locations.edit', compact('slideLocation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SlideLocation $slideLocation)
    {
        $rules = [
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ];
        
        $messages = [
            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, webp.',
            'image.max' => 'Ảnh không được lớn hơn 5MB.',
        ];
        
        $validated = $request->validate($rules, $messages);
        
        try {
            $oldImage = $slideLocation->image;
            $newImagePath = $oldImage;
            
            if ($request->hasFile('image')) {
                $newImagePath = ImageHelper::optimizeAndSave(
                    $request->file('image'),
                    'slide-locations',
                    null, // width = null (không resize)
                    95    // quality = 95
                );
                
                // Xóa ảnh cũ nếu upload thành công
                if ($oldImage && $newImagePath !== $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }
            
            $slideLocation->update([
                'image' => $newImagePath,
                'sort_order' => $request->sort_order ?? $slideLocation->sort_order,
                'is_active' => $request->has('is_active'),
            ]);
            
            return redirect()->route('admin.slide-locations.index')
                ->with('success', 'Slide vị trí đã được cập nhật thành công.');
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
    public function destroy(SlideLocation $slideLocation)
    {
        try {
            if ($slideLocation->image) {
                Storage::disk('public')->delete($slideLocation->image);
            }
            
            $slideLocation->delete();
            
            return redirect()->route('admin.slide-locations.index')
                ->with('success', 'Slide vị trí đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.slide-locations.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
} 