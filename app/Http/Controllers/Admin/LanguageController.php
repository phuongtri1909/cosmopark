<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;

class LanguageController extends Controller
{
    /**
     * Hiển thị trang quản lý ngôn ngữ
     */
    public function index()
    {
        return view('admin.pages.languages.index');
    }

    /**
     * Lấy nội dung file ngôn ngữ
     */
    public function getLanguageContent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required|in:vi,en'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ngôn ngữ không hợp lệ'
            ]);
        }

        $language = $request->language;
        $filePath = lang_path($language . '.json');

        try {
            if (!File::exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File ngôn ngữ không tồn tại'
                ]);
            }

            $content = File::get($filePath);

            // Validate JSON
            $decoded = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'File JSON không hợp lệ: ' . json_last_error_msg()
                ]);
            }

            return response()->json([
                'success' => true,
                'content' => $content
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi đọc file: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Cập nhật nội dung file ngôn ngữ
     */
    public function updateLanguageContent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required|in:vi,en',
            'content' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ'
            ]);
        }

        $language = $request->language;
        $content = $request->content;
        $filePath = lang_path($language . '.json');

        try {
            // Validate JSON format
            $decoded = json_decode($content, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'JSON không hợp lệ: ' . json_last_error_msg()
                ]);
            }

            // Validate structure - ensure all keys are strings
            $this->validateJsonStructure($decoded);

            // Create backup
            if (File::exists($filePath)) {
                $backupPath = lang_path($language . '_backup_' . date('Y-m-d_H-i-s') . '.json');
                File::copy($filePath, $backupPath);
            }

            // Write new content
            File::put($filePath, $content);

            // Clear cache
            Artisan::call('cache:clear');

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Validate JSON structure to ensure all keys are strings
     */
    private function validateJsonStructure($data, $path = '')
    {
        if (!is_array($data)) {
            return;
        }

        foreach ($data as $key => $value) {
            $currentPath = $path ? $path . '.' . $key : $key;

            if (!is_string($key)) {
                throw new \Exception("Key phải là string: " . $currentPath);
            }

            if (is_array($value)) {
                $this->validateJsonStructure($value, $currentPath);
            }
        }
    }

    /**
     * Tạo file ngôn ngữ mới (nếu cần)
     */
    public function createLanguageFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'language' => 'required|in:vi,en'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ngôn ngữ không hợp lệ'
            ]);
        }

        $language = $request->language;
        $filePath = lang_path($language . '.json');

        try {
            if (File::exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File ngôn ngữ đã tồn tại'
                ]);
            }

            // Create empty JSON file
            File::put($filePath, '{}');

            return response()->json([
                'success' => true,
                'message' => 'Tạo file ngôn ngữ thành công'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi tạo file: ' . $e->getMessage()
            ]);
        }
    }
}
