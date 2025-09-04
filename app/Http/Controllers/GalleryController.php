<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Project;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display gallery index page
     */
    public function index(Request $request)
    {
        try {
            return view('client.pages.gallery');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load gallery');
        }
    }

    /**
     * Load more galleries (legacy method)
     */
    public function loadMore(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 8);
            
            $galleries = Gallery::active()
                ->ordered()
                ->paginate($perPage, ['*'], 'page', $page);
            
            return response()->json([
                'success' => true,
                'data' => $galleries
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load more galleries'
                ], 500);
            }

            return back()->with('error', 'Failed to load more galleries');
        }
    }

    /**
     * Get all projects with gallery count
     */
    public function getProjects(Request $request)
    {
        try {
            $projects = Project::active()
                ->ordered()
                ->withCount('activeGalleries')
                ->get()
                ->map(function ($project) {
                    return [
                        'id' => $project->id,
                        'title' => $project->getTranslation('title', app()->getLocale()),
                        'slug' => $project->slug,
                        'active_galleries_count' => $project->active_galleries_count
                    ];
                });

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $projects
                ]);
            }

            return view('gallery.projects', compact('projects'));
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load projects'
                ], 500);
            }

            return back()->with('error', 'Failed to load projects');
        }
    }

    /**
     * Get galleries for specific project
     */
    public function getByProject(Request $request, $projectId)
    {
        try {
            $project = Project::findOrFail($projectId);
            
            $totalGalleries = Gallery::byProject($projectId)->active()->count();
            $galleries = Gallery::byProject($projectId)
                ->active()
                ->ordered()
                ->with('project')
                ->limit(2)
                ->get();
            
            if ($request->ajax()) {
                // Render HTML components
                $html = '';
                foreach ($galleries as $index => $gallery) {
                    $html .= view('components.gallery-row', [
                        'gallery' => $gallery,
                        'index' => $index
                    ])->render();
                }
                
                return response()->json([
                    'success' => true,
                    'data' => [
                        'project' => [
                            'id' => $project->id,
                            'title' => $project->getTranslation('title', app()->getLocale()),
                            'slug' => $project->slug
                        ],
                        'galleries' => $galleries,
                        'html' => $html,
                        'total_galleries' => $totalGalleries,
                        'has_more' => $totalGalleries > $galleries->count()
                    ]
                ]);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'project' => [
                        'id' => $project->id,
                        'title' => $project->getTranslation('title', app()->getLocale()),
                        'slug' => $project->slug
                    ],
                    'galleries' => $galleries
                ]
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load gallery'
                ], 500);
            }

            return back()->with('error', 'Failed to load gallery');
        }
    }

    /**
     * Load more galleries for specific project
     */
    public function loadMoreByProject(Request $request, $projectId)
    {
        try {
            $page = $request->get('page', 2);
            $perPage = $request->get('per_page', 2);
            
            // Đếm tổng số gallery để tính has_more chính xác
            $totalGalleries = Gallery::byProject($projectId)->active()->count();
            $skipCount = ($page - 1) * $perPage;
            
            $galleries = Gallery::byProject($projectId)
                ->active()
                ->ordered()
                ->with('project')
                ->skip($skipCount)
                ->take($perPage)
                ->get();
            
            // Tính has_more dựa trên tổng số và số đã skip
            $hasMore = ($skipCount + $galleries->count()) < $totalGalleries;
            
            if ($request->ajax()) {
              
                $html = '';
                $startIndex = ($page - 1) * $perPage; // Calculate starting index for alternating layout
                foreach ($galleries as $index => $gallery) {
                    $html .= view('components.gallery-row', [
                        'gallery' => $gallery,
                        'index' => $startIndex + $index
                    ])->render();
                }
                
                return response()->json([
                    'success' => true,
                    'data' => [
                        'data' => $galleries,
                        'html' => $html,
                        'current_page' => $page,
                        'per_page' => $perPage,
                        'has_more' => $hasMore,
                        'total_galleries' => $totalGalleries,
                        'loaded_count' => $skipCount + $galleries->count()
                    ]
                ]);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'data' => $galleries,
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'has_more' => $hasMore,
                    'total_galleries' => $totalGalleries,
                    'loaded_count' => $skipCount + $galleries->count()
                ]
            ]);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to load more galleries'
                ], 500);
            }

            return back()->with('error', 'Failed to load more galleries');
        }
    }
}