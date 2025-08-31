<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\BannerHome;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;

class BannerHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bannerHomes = BannerHome::orderBy('sort_order', 'asc')
            ->paginate(10);
            
        return view('admin.pages.banner-homes.index', compact('bannerHomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.banner-homes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ],[
            'image.required' => 'Hình ảnh là bắt buộc',
            'image.image' => 'Hình ảnh phải là định dạng ảnh',
            'image.mimes' => 'Hình ảnh phải là định dạng jpeg, png, jpg, gif',
        ]);
        
        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = ImageHelper::optimizeAndSave(
                    $request->file('image'),
                    'banner-homes',
                    1200,
                    95
                );
            }
            
            $validated['image'] = $imagePath;
            $validated['is_active'] = $request->has('is_active');
            
            BannerHome::create($validated);
            
            return redirect()->route('admin.banner-homes.index')
                ->with('success', 'Banner trang chủ đã được tạo thành công.');
        } catch (\Exception $e) {
            if ($imagePath) {
                ImageHelper::delete($imagePath);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BannerHome $bannerHome)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BannerHome $bannerHome)
    {
        return view('admin.pages.banner-homes.edit', compact('bannerHome'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BannerHome $bannerHome)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ],[
            'image.image' => 'Hình ảnh phải là định dạng ảnh',
            'image.mimes' => 'Hình ảnh phải là định dạng jpeg, png, jpg, gif',
        ]);
        
        try {
            if ($request->hasFile('image')) {
                $oldImagePath = $bannerHome->image;
                
                $imagePath = ImageHelper::optimizeAndSave(
                    $request->file('image'),
                    'banner-homes',
                    1200,
                    90 
                );
                
                $validated['image'] = $imagePath;
            }
            
            $validated['is_active'] = $request->has('is_active');
            
            $bannerHome->update($validated);
            
            if (isset($oldImagePath)) {
                ImageHelper::delete($oldImagePath);
            }
            
            return redirect()->route('admin.banner-homes.index')
                ->with('success', 'Banner trang chủ đã được cập nhật thành công.');
        } catch (\Exception $e) {
            if (isset($imagePath)) {
                ImageHelper::delete($imagePath);
            }
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BannerHome $bannerHome)
    {
        try {
            $oldImagePath = $bannerHome->image;
            
            $bannerHome->delete();
            
            if ($oldImagePath) {
                ImageHelper::delete($oldImagePath);
            }
            
            return redirect()->route('admin.banner-homes.index')
                ->with('success', 'Banner trang chủ đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.banner-homes.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
} 