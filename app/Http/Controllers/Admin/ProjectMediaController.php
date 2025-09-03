<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProjectMediaController extends Controller
{
    protected $languages;

    public function __construct()
    {
        $this->languages = ['vi' => 'Tiếng Việt', 'en' => 'English'];
    }

    /**
     * Display media for a specific project
     */
    public function index(Project $project)
    {
        $media = $project->media()->with('project')->ordered()->paginate(20);
        return view('admin.pages.project-media.index', compact('project', 'media'));
    }

    /**
     * Show the form for creating new media
     */
    public function create(Project $project)
    {
        $languages = $this->languages;
        $mediaTypes = [
            'images' => 'Hình ảnh',
            'plans' => 'Kế hoạch',
            'videos' => 'Video (YouTube)',
            'street-views' => 'Góc nhìn đường phố'
        ];
        return view('admin.pages.project-media.create', compact('project', 'languages', 'mediaTypes'));
    }

    /**
     * Store a newly created media
     */
    public function store(Request $request, Project $project)
    {
        $rules = [
            'type' => 'required|in:images,plans,videos,street-views',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|accepted',
        ];

        // Validation rules based on media type
        if (in_array($request->type, ['images', 'plans', 'street-views'])) {
            $rules['media_file'] = 'required|file|mimes:jpeg,png,jpg,gif,webp|max:10240';
        } else {
            $rules['video_url'] = 'required|url|max:500';
        }

        $validated = $request->validate($rules, [
            'type.required' => 'Loại media là bắt buộc.',
            'type.in' => 'Loại media không hợp lệ.',
            'media_file.required' => 'File media là bắt buộc.',
            'media_file.file' => 'File phải là file hợp lệ.',
            'media_file.mimes' => 'File phải có định dạng: jpeg, png, jpg, gif, webp.',
            'media_file.max' => 'Kích thước file không được vượt quá 10MB.',
            'video_url.required' => 'URL video là bắt buộc.',
            'video_url.url' => 'URL không hợp lệ.',
        ]);

        try {
            $data = [
                'project_id' => $project->id,
                'type' => $request->type,
                'title' => $request->title,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? 0,
                'is_active' => $request->has('is_active'),
            ];

            if (in_array($request->type, ['images', 'plans', 'street-views'])) {
                // Handle file upload
                if ($request->hasFile('media_file')) {
                    $filePath = $request->file('media_file')->store('project-media', 'public');
                    $data['file_path'] = $filePath;
                }
            } else {
                // Handle YouTube URL
                $data['video_url'] = $request->video_url;
            }

            ProjectMedia::create($data);

            return redirect()->route('admin.projects.media.index', $project)
                ->with('success', 'Media đã được tạo thành công.');
        } catch (\Exception $e) {
            Log::error('ProjectMedia creation failed:', [
                'error' => $e->getMessage(),
                'project_id' => $project->id
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing media
     */
    public function edit(Project $project, ProjectMedia $media)
    {
        $languages = $this->languages;
        $mediaTypes = [
            'images' => 'Hình ảnh',
            'plans' => 'Kế hoạch',
            'videos' => 'Video (YouTube)',
            'street-views' => 'Góc nhìn đường phố'
        ];
        return view('admin.pages.project-media.edit', compact('project', 'media', 'languages', 'mediaTypes'));
    }

    /**
     * Update the specified media
     */
    public function update(Request $request, Project $project, ProjectMedia $media)
    {
        $rules = [
            'type' => 'required|in:images,plans,videos,street-views',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'sometimes|accepted',
        ];

        // Validation rules based on media type
        if (in_array($request->type, ['images', 'plans', 'street-views'])) {
            $rules['media_file'] = 'nullable|file|mimes:jpeg,png,jpg,gif,webp|max:10240';
        } else {
            $rules['video_url'] = 'required|url|max:500';
        }

        $validated = $request->validate($rules, [
            'type.required' => 'Loại media là bắt buộc.',
            'type.in' => 'Loại media không hợp lệ.',
            'media_file.file' => 'File phải là file hợp lệ.',
            'media_file.mimes' => 'File phải có định dạng: jpeg, png, jpg, gif, webp.',
            'media_file.max' => 'Kích thước file không được vượt quá 10MB.',
            'video_url.required' => 'URL video là bắt buộc.',
            'video_url.url' => 'URL không hợp lệ.',
        ]);

        try {
            $data = [
                'type' => $request->type,
                'title' => $request->title,
                'description' => $request->description,
                'sort_order' => $request->sort_order ?? $media->sort_order,
                'is_active' => $request->has('is_active'),
            ];

            if (in_array($request->type, ['images', 'plans', 'street-views'])) {
                // Handle file upload
                if ($request->hasFile('media_file')) {
                    // Delete old file if exists
                    if ($media->file_path) {
                        Storage::disk('public')->delete($media->file_path);
                    }
                    
                    $filePath = $request->file('media_file')->store('project-media', 'public');
                    $data['file_path'] = $filePath;
                    $data['video_url'] = null; // Clear video URL
                }
            } else {
                // Handle YouTube URL
                $data['video_url'] = $request->video_url;
                $data['file_path'] = null; // Clear file path
            }

            $media->update($data);

            return redirect()->route('admin.projects.media.index', $project)
                ->with('success', 'Media đã được cập nhật thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified media
     */
    public function destroy(Project $project, ProjectMedia $media)
    {
        try {
            // Delete file if exists
            if ($media->file_path) {
                Storage::disk('public')->delete($media->file_path);
            }
            
            $media->delete();

            return redirect()->route('admin.projects.media.index', $project)
                ->with('success', 'Media đã được xóa thành công.');
        } catch (\Exception $e) {
            return redirect()->route('admin.projects.media.index', $project)
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Update media order
     */
    public function updateOrder(Request $request, Project $project)
    {
        $request->validate([
            'media_order' => 'required|array',
            'media_order.*' => 'required|integer|exists:project_media,id'
        ]);

        try {
            foreach ($request->media_order as $index => $mediaId) {
                ProjectMedia::where('id', $mediaId)->update(['sort_order' => $index]);
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra'], 500);
        }
    }
} 