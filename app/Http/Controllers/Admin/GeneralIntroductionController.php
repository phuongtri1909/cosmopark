<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\GeneralIntroduction;
use Illuminate\Http\Request;

class GeneralIntroductionController extends Controller
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
        $generalIntroduction = GeneralIntroduction::first();
        return view('admin.pages.general-introductions.index', compact('generalIntroduction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->languages;
        return view('admin.pages.general-introductions.create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'is_active' => 'sometimes|boolean',
        ];
        
        foreach ($this->languages as $lang => $langName) {
            $rules["title.$lang"] = 'required|string|max:255';
            $rules["content.$lang"] = 'required|string|max:1000';
        }
        
        $messages = [
            'title.vi.required' => 'Tiêu đề (VI) là bắt buộc.',
            'title.en.required' => 'Tiêu đề (EN) là bắt buộc.',
            'content.vi.required' => 'Nội dung (VI) là bắt buộc.',
            'content.en.required' => 'Nội dung (EN) là bắt buộc.',
        ];
        
        $validated = $request->validate($rules, $messages);
        
        try {
            $validated['is_active'] = $request->has('is_active');
            
            GeneralIntroduction::create([
                'title' => $request->title,
                'content' => $request->content,
                'is_active' => $validated['is_active'],
            ]);
            
            return redirect()->route('admin.general-introductions.index')
                ->with('success', 'Giới thiệu chung đã được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GeneralIntroduction $generalIntroduction)
    {
        $languages = $this->languages;
        return view('admin.pages.general-introductions.edit', compact('generalIntroduction', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GeneralIntroduction $generalIntroduction)
    {
        $rules = [
            'is_active' => 'sometimes|boolean',
        ];
        
        foreach ($this->languages as $lang => $langName) {
            $rules["title.$lang"] = 'required|string|max:255';
            $rules["content.$lang"] = 'required|string|max:1000';
        }
        
        $messages = [
            'title.vi.required' => 'Tiêu đề (VI) là bắt buộc.',
            'title.en.required' => 'Tiêu đề (EN) là bắt buộc.',
            'content.vi.required' => 'Nội dung (VI) là bắt buộc.',
            'content.en.required' => 'Nội dung (EN) là bắt buộc.',
        ];
        
        $validated = $request->validate($rules, $messages);
        
        try {
            $validated['is_active'] = $request->has('is_active');
            
            $generalIntroduction->update([
                'title' => $request->title,
                'content' => $request->content,
                'is_active' => $validated['is_active'],
            ]);
            
            return redirect()->route('admin.general-introductions.index')
                ->with('success', 'Giới thiệu chung đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
} 