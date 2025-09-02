<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class IndustryController extends Controller
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
        $industries = Industry::ordered()->paginate(10);
        return view('admin.pages.industries.index', compact('industries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->languages;
        return view('admin.pages.industries.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|accepted',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        
        foreach ($this->languages as $lang => $langName) {
            $rules["name.$lang"] = 'required|string|max:255';
            $rules["description.$lang"] = 'required|string|max:1000';
        }
        
        $messages = [
            'name.vi.required' => 'Tên ngành (VI) là bắt buộc.',
            'name.en.required' => 'Tên ngành (EN) là bắt buộc.',
            'description.vi.required' => 'Mô tả (VI) là bắt buộc.',
            'description.en.required' => 'Mô tả (EN) là bắt buộc.',
            'icon.image' => 'File phải là hình ảnh.',
            'icon.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'icon.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ];
        
        try {
            $validated = $request->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Industry validation failed:', [
                'errors' => $e->errors()
            ]);
            throw $e;
        }
        
        try {
            $isActive = $request->has('is_active');
            $sortOrder = $request->sort_order ?? 0;
            
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'sort_order' => $sortOrder,
                'is_active' => $isActive,
            ];

            // Xử lý upload icon
            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('industries', 'public');
                $data['icon'] = $iconPath;
            }
            
            $industry = Industry::create($data);
            
            Log::info('Industry created successfully:', ['id' => $industry->id]);
            
            return redirect()->route('admin.industries.index')
                ->with('success', 'Ngành công nghiệp đã được tạo thành công.');
        } catch (\Exception $e) {
            Log::error('Industry creation failed:', [
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
    public function edit(Industry $industry)
    {
        $languages = $this->languages;
        return view('admin.pages.industries.edit', compact('industry', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Industry $industry)
    {
        $rules = [
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|accepted',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        
        foreach ($this->languages as $lang => $langName) {
            $rules["name.$lang"] = 'required|string|max:255';
            $rules["description.$lang"] = 'required|string|max:1000';
        }
        
        $messages = [
            'name.vi.required' => 'Tên ngành (VI) là bắt buộc.',
            'name.en.required' => 'Tên ngành (EN) là bắt buộc.',
            'description.vi.required' => 'Mô tả (VI) là bắt buộc.',
            'description.en.required' => 'Mô tả (EN) là bắt buộc.',
            'icon.image' => 'File phải là hình ảnh.',
            'icon.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, svg.',
            'icon.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
        ];
        
        $validated = $request->validate($rules, $messages);
        
        try {
            $data = [
                'name' => $request->name,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? $industry->sort_order,
                'is_active' => $request->has('is_active'),
            ];

            // Xử lý upload icon mới
            if ($request->hasFile('icon')) {
                // Xóa icon cũ nếu có
                if ($industry->icon) {
                    Storage::disk('public')->delete($industry->icon);
                }
                
                $iconPath = $request->file('icon')->store('industries', 'public');
                $data['icon'] = $iconPath;
            }
            
            $industry->update($data);
            
            return redirect()->route('admin.industries.index')
                ->with('success', 'Ngành công nghiệp đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Industry $industry)
    {
        try {
            // Xóa icon nếu có
            if ($industry->icon) {
                Storage::disk('public')->delete($industry->icon);
            }
            
            $industry->delete();
            
            return redirect()->route('admin.industries.index')
                ->with('success', 'Ngành công nghiệp đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.industries.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
} 