<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VisionMissionController extends Controller
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
        $visionMissions = VisionMission::ordered()->paginate(10);
        return view('admin.pages.vision-missions.index', compact('visionMissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->languages;
        return view('admin.pages.vision-missions.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'type' => 'required|in:vision,mission',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|accepted',
        ];
        
        foreach ($this->languages as $lang => $langName) {
            $rules["title.$lang"] = 'required|string|max:255';
            $rules["description.$lang"] = 'required|string|max:1000';
        }
        
        $messages = [
            'type.required' => 'Loại là bắt buộc.',
            'type.in' => 'Loại phải là vision hoặc mission.',
            'title.vi.required' => 'Tiêu đề (VI) là bắt buộc.',
            'title.en.required' => 'Tiêu đề (EN) là bắt buộc.',
            'description.vi.required' => 'Mô tả (VI) là bắt buộc.',
            'description.en.required' => 'Mô tả (EN) là bắt buộc.',
        ];
        
        try {
            $validated = $request->validate($rules, $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('VisionMission validation failed:', [
                'errors' => $e->errors()
            ]);
            throw $e;
        }
        
        try {
            $isActive = $request->has('is_active');
            $sortOrder = $request->sort_order ?? 0;
            
            $visionMission = VisionMission::create([
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'sort_order' => $sortOrder,
                'is_active' => $isActive,
            ]);
            
            Log::info('VisionMission created successfully:', ['id' => $visionMission->id]);
            
            return redirect()->route('admin.vision-missions.index')
                ->with('success', 'Tầm nhìn/Sứ mệnh đã được tạo thành công.');
        } catch (\Exception $e) {
            Log::error('VisionMission creation failed:', [
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
    public function edit(VisionMission $visionMission)
    {
        $languages = $this->languages;
        return view('admin.pages.vision-missions.edit', compact('visionMission', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VisionMission $visionMission)
    {
        $rules = [
            'type' => 'required|in:vision,mission',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|accepted',
        ];
        
        foreach ($this->languages as $lang => $langName) {
            $rules["title.$lang"] = 'required|string|max:255';
            $rules["description.$lang"] = 'required|string|max:1000';
        }
        
        $messages = [
            'type.required' => 'Loại là bắt buộc.',
            'type.in' => 'Loại phải là vision hoặc mission.',
            'title.vi.required' => 'Tiêu đề (VI) là bắt buộc.',
            'title.en.required' => 'Tiêu đề (EN) là bắt buộc.',
            'description.vi.required' => 'Mô tả (VI) là bắt buộc.',
            'description.en.required' => 'Mô tả (EN) là bắt buộc.',
        ];
        
        $validated = $request->validate($rules, $messages);
        
        try {
            $visionMission->update([
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'sort_order' => $request->sort_order ?? $visionMission->sort_order,
                'is_active' => $request->has('is_active'),
            ]);
            
            return redirect()->route('admin.vision-missions.index')
                ->with('success', 'Tầm nhìn/Sứ mệnh đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VisionMission $visionMission)
    {
        try {
            $visionMission->delete();
            
            return redirect()->route('admin.vision-missions.index')
                ->with('success', 'Tầm nhìn/Sứ mệnh đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.vision-missions.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
} 