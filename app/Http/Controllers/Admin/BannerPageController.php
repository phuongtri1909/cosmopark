<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BannerPageController extends Controller
{
    protected $languages;

    public function __construct()
    {
        $this->languages = ['vi' => 'Tiếng Việt', 'en' => 'English'];
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $pageKey = $request->get('page');
        
        if (!$pageKey || !in_array($pageKey, ['contact', 'news', 'gallery'])) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Trang không hợp lệ.');
        }
        
        // Tìm hoặc tạo banner page cho page này
        $bannerPage = BannerPage::where('key', $pageKey)->first();
        
        if (!$bannerPage) {
            // Tạo banner page mới nếu chưa có
            $bannerPage = BannerPage::create([
                'key' => $pageKey,
                'title' => [
                    'vi' => $pageKey === 'contact' ? 'Liên hệ' : ($pageKey === 'news' ? 'Tin tức' : 'Thư viện ảnh'),
                    'en' => ucfirst($pageKey)
                ],
                'is_active' => true,
                'sort_order' => 0
            ]);
        }
        
        $languages = $this->languages;
        return view('admin.pages.banner-pages.edit', compact('bannerPage', 'languages', 'pageKey'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BannerPage $bannerPage)
    {
        $rules = [
            'key' => 'required|string|max:255|unique:banner_pages,key,' . $bannerPage->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'is_active' => 'sometimes|accepted',
        ];
        
        foreach ($this->languages as $lang => $langName) {
            $rules["title.$lang"] = 'required|string|max:255';
        }
        
        $messages = [
            'key.required' => 'Key là bắt buộc.',
            'key.unique' => 'Key đã tồn tại.',
            'title.vi.required' => 'Tiêu đề (VI) là bắt buộc.',
            'title.en.required' => 'Tiêu đề (EN) là bắt buộc.',
            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif, webp.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 10MB.',
        ];
        
        $validated = $request->validate($rules, $messages);
        
        try {
            $data = [
                'key' => $request->key,
                'title' => $request->title,
                'is_active' => $request->has('is_active'),
            ];

            // Xử lý upload image mới
            if ($request->hasFile('image')) {
                // Xóa image cũ nếu có
                if ($bannerPage->image) {
                    Storage::disk('public')->delete($bannerPage->image);
                }
                
                $imagePath = $request->file('image')->store('banner-pages', 'public');
                $data['image'] = $imagePath;
            }
            
            $bannerPage->update($data);
            
            return redirect()->route('admin.banner-pages.edit', ['page' => $bannerPage->key])
                ->with('success', 'Banner trang đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

}