<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectMediaController extends Controller
{
    /**
     * Get media for a specific project and type
     */
    public function getMedia(Request $request, $projectSlug, $type)
    {
        try {
            $project = Project::where('slug', $projectSlug)->first();
            
            if (!$project) {
                return response()->json(['error' => 'Project not found'], 404);
            }

            // Validate media type
            $validTypes = ['images', 'plans', 'videos', 'street-views'];
            if (!in_array($type, $validTypes)) {
                return response()->json(['error' => 'Invalid media type'], 400);
            }

            $media = $project->media()
                ->where('type', $type)
                ->active()
                ->ordered()
                ->get();

            if ($type === 'videos') {
                // Return video URLs for embedding
                $data = $media->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'title' => $item->title,
                        'description' => $item->description,
                        'video_url' => $item->video_url,
                        'embed_url' => $item->youtube_embed_url,
                        'thumbnail_url' => $item->thumbnail_url,
                    ];
                });
            } else {
                // Return file paths for images, plans, street-views
                $data = $media->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'title' => $item->title,
                        'description' => $item->description,
                        'file_url' => $item->file_url,
                    ];
                });
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
} 