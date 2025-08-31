<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\IntroFeature;
use Illuminate\Http\Request;

class IntroFeatureController extends Controller
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
        $introFeatures = IntroFeature::orderBy('sort_order', 'asc')->paginate(10);
        return view('admin.pages.intro-features.index', compact('introFeatures'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->languages;
        return view('admin.pages.intro-features.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ];
        
        foreach ($this->languages as $lang => $langName) {
            $rules["name.$lang"] = 'required|string|max:255';
            $rules["value.$lang"] = 'required|string|max:100';
            $rules["unit.$lang"] = 'required|string|max:50';
        }
        
        $messages = [
            'name.vi.required' => 'Tên tính năng (VI) là bắt buộc.',
            'name.en.required' => 'Tên tính năng (EN) là bắt buộc.',
            'value.vi.required' => 'Giá trị (VI) là bắt buộc.',
            'value.en.required' => 'Giá trị (EN) là bắt buộc.',
            'unit.vi.required' => 'Đơn vị (VI) là bắt buộc.',
            'unit.en.required' => 'Đơn vị (EN) là bắt buộc.',
        ];
        
        $validated = $request->validate($rules, $messages);
        
        try {
            $validated['is_active'] = $request->has('is_active');
            
            IntroFeature::create([
                'name' => $request->name,
                'value' => $request->value,
                'unit' => $request->unit,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $validated['is_active'],
            ]);
            
            return redirect()->route('admin.general-introductions.index', ['tab' => 'features'])
                ->with('success', 'Tính năng giới thiệu đã được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IntroFeature $introFeature)
    {
        $languages = $this->languages;
        return view('admin.pages.intro-features.edit', compact('introFeature', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IntroFeature $introFeature)
    {
        $rules = [
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ];
        
        foreach ($this->languages as $lang => $langName) {
            $rules["name.$lang"] = 'required|string|max:255';
            $rules["value.$lang"] = 'required|string|max:100';
            $rules["unit.$lang"] = 'required|string|max:50';
        }
        
        $messages = [
            'name.vi.required' => 'Tên tính năng (VI) là bắt buộc.',
            'name.en.required' => 'Tên tính năng (EN) là bắt buộc.',
            'value.vi.required' => 'Giá trị (VI) là bắt buộc.',
            'value.en.required' => 'Giá trị (EN) là bắt buộc.',
            'unit.vi.required' => 'Đơn vị (VI) là bắt buộc.',
            'unit.en.required' => 'Đơn vị (EN) là bắt buộc.',
        ];
        
        $validated = $request->validate($rules, $messages);
        
        try {
            $validated['is_active'] = $request->has('is_active');
            
            $introFeature->update([
                'name' => $request->name,
                'value' => $request->value,
                'unit' => $request->unit,
                'sort_order' => $request->sort_order ?? $introFeature->sort_order,
                'is_active' => $validated['is_active'],
            ]);
            
            return redirect()->route('admin.general-introductions.index', ['tab' => 'features'])
                ->with('success', 'Tính năng giới thiệu đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IntroFeature $introFeature)
    {
        try {
            $introFeature->delete();
            
            return redirect()->route('admin.general-introductions.index', ['tab' => 'features'])
                ->with('success', 'Tính năng giới thiệu đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.general-introductions.index', ['tab' => 'features'])
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
} 