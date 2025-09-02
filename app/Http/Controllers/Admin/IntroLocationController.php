<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IntroLocation;
use App\Models\IntroLocationStat;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IntroLocationController extends Controller
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
        $introLocations = IntroLocation::ordered()->paginate(10);
        return view('admin.pages.intro-locations.index', compact('introLocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->languages;
        return view('admin.pages.intro-locations.create', compact('languages'));
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
        
        // Stats validation - check if stats exist
        if ($request->has('stats') && is_array($request->stats)) {
            foreach ($request->stats as $index => $stat) {
                if (isset($stat['label']) && isset($stat['value'])) {
                    foreach ($this->languages as $lang => $langName) {
                        $rules["stats.$index.label.$lang"] = 'required|string|max:100';
                        $rules["stats.$index.value.$lang"] = 'required|string|max:50';
                        $rules["stats.$index.unit.$lang"] = 'nullable|string|max:20';
                    }
                }
            }
        }
        
        $messages = [
            'image.required' => 'Ảnh vị trí là bắt buộc.',
            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, webp.',
            'image.max' => 'Ảnh không được lớn hơn 5MB.',
            'title.vi.required' => 'Tiêu đề (VI) là bắt buộc.',
            'title.en.required' => 'Tiêu đề (EN) là bắt buộc.',
            'description.vi.required' => 'Mô tả (VI) là bắt buộc.',
            'description.en.required' => 'Mô tả (EN) là bắt buộc.',
        ];
        
        // Stats validation messages
        foreach ($this->languages as $lang => $langName) {
            $messages["stats.*.label.$lang.required"] = "Nhãn ($langName) là bắt buộc.";
            $messages["stats.*.value.$lang.required"] = "Giá trị ($langName) là bắt buộc.";
        }
        
        try {
            $validated = $request->validate($rules, $messages);
            Log::info('Validation passed, validated data:', $validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            throw $e;
        }
        
        try {
            DB::beginTransaction();
            
            // Debug logging
            Log::info('IntroLocation create request data:', [
                'title' => $request->title,
                'description' => $request->description,
                'stats' => $request->stats ?? 'no stats',
                'has_image' => $request->hasFile('image'),
                'is_active' => $request->has('is_active'),
                'sort_order' => $request->sort_order
            ]);
            
            Log::info('Request all data:', $request->all());
            
            if ($request->hasFile('image')) {
                $imagePath = ImageHelper::optimizeAndSave(
                    $request->file('image'),
                    'intro-locations',
                    null,
                    95
                );
            }
            
            $isActive = $request->has('is_active');
            $imagePath = $imagePath ?? null;
            $sortOrder = $request->sort_order ?? 0;
            
            $introLocation = IntroLocation::create([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $imagePath,
                'sort_order' => $sortOrder,
                'is_active' => $isActive,
            ]);
            
            // Create stats
            if (isset($request->stats) && is_array($request->stats)) {
                Log::info('Creating stats:', $request->stats);
                
                foreach ($request->stats as $index => $stat) {
                    if (isset($stat['label']) && isset($stat['value'])) {
                        // Create multi-language stat
                        $statData = [
                            'intro_location_id' => $introLocation->id,
                            'sort_order' => $index
                        ];
                        
                        // Add translations for each language
                        foreach ($this->languages as $lang => $langName) {
                            if (isset($stat['label'][$lang])) {
                                $statData['label'][$lang] = $stat['label'][$lang];
                                $statData['value'][$lang] = $stat['value'][$lang];
                                $statData['unit'][$lang] = $stat['unit'][$lang] ?? null;
                            }
                        }
                        
                        Log::info('Creating stat:', $statData);
                        IntroLocationStat::create($statData);
                    }
                }
            }
            
            DB::commit();
            
            return redirect()->route('admin.intro-locations.index')
                ->with('success', 'Thông tin vị trí đã được tạo thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating IntroLocation:', [
                'message' => $e->getMessage(),
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
    public function edit(IntroLocation $introLocation)
    {
        $languages = $this->languages;
        
        // Load stats
        $stats = $introLocation->stats()->ordered()->get();
        
        return view('admin.pages.intro-locations.edit', compact('introLocation', 'languages', 'stats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IntroLocation $introLocation)
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
        
        // Stats validation - check if stats exist
        if ($request->has('stats') && is_array($request->stats)) {
            foreach ($request->stats as $index => $stat) {
                if (isset($stat['label']) && isset($stat['value'])) {
                    foreach ($this->languages as $lang => $langName) {
                        $rules["stats.$index.label.$lang"] = 'required|string|max:100';
                        $rules["stats.$index.value.$lang"] = 'required|string|max:50';
                        $rules["stats.$index.unit.$lang"] = 'nullable|string|max:20';
                    }
                }
            }
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
        
        // Stats validation messages
        foreach ($this->languages as $lang => $langName) {
            $messages["stats.*.label.$lang.required"] = "Nhãn ($langName) là bắt buộc.";
            $messages["stats.*.value.$lang.required"] = "Giá trị ($langName) là bắt buộc.";
        }
        
        try {
            $validated = $request->validate($rules, $messages);
            Log::info('Validation passed, validated data:', $validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            throw $e;
        }
        
        try {
            DB::beginTransaction();
            
            // Debug logging
            Log::info('IntroLocation update request data:', [
                'title' => $request->title,
                'description' => $request->description,
                'stats' => $request->stats ?? 'no stats',
                'has_image' => $request->hasFile('image')
            ]);
            
            if ($request->hasFile('image')) {
                if ($introLocation->image) {
                    Storage::disk('public')->delete($introLocation->image);
                }
                
                $imagePath = ImageHelper::optimizeAndSave(
                    $request->file('image'),
                    'intro-locations',
                    null,
                    80
                );
                
                $validated['image'] = $imagePath;
            }
            
            $validated['is_active'] = $request->has('is_active');
        
            $introLocation->update([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $validated['image'] ?? $introLocation->image,
                'sort_order' => $request->sort_order ?? $introLocation->sort_order,
                'is_active' => $validated['is_active'],
            ]);
            
            // Delete existing stats
            $introLocation->stats()->delete();
            
            // Create new stats
            if (isset($request->stats) && is_array($request->stats)) {
                Log::info('Creating new stats:', $request->stats);
                
                foreach ($request->stats as $index => $stat) {
                    if (isset($stat['label']) && isset($stat['value'])) {
                        // Create multi-language stat
                        $statData = [
                            'intro_location_id' => $introLocation->id,
                            'sort_order' => $index
                        ];
                        
                        // Add translations for each language
                        foreach ($this->languages as $lang => $langName) {
                            if (isset($stat['label'][$lang])) {
                                $statData['label'][$lang] = $stat['label'][$lang];
                                $statData['value'][$lang] = $stat['value'][$lang];
                                $statData['unit'][$lang] = $stat['unit'][$lang] ?? null;
                            }
                        }
                        
                        Log::info('Creating stat:', $statData);
                        IntroLocationStat::create($statData);
                    }
                }
            }
                
            DB::commit();
            
            return redirect()->route('admin.intro-locations.index')
                ->with('success', 'Thông tin vị trí đã được cập nhật thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating IntroLocation:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IntroLocation $introLocation)
    {
        try {
            if ($introLocation->image) {
                Storage::disk('public')->delete($introLocation->image);
            }
            
            $introLocation->delete();
            
            return redirect()->route('admin.intro-locations.index')
                ->with('success', 'Thông tin vị trí đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.intro-locations.index')
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
} 