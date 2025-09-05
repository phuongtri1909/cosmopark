<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageView;
use App\Models\ContactSubmission;
use App\Models\Blog;
use App\Models\Project;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $pageViewStats = PageView::getStats(30);
        
        $contactStats = [
            'total' => ContactSubmission::count(),
            'this_month' => ContactSubmission::whereMonth('created_at', Carbon::now()->month)->count(),
            'this_week' => ContactSubmission::whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(),
            'today' => ContactSubmission::whereDate('created_at', Carbon::today())->count()
        ];
        
        $contentStats = [
            'blogs' => [
                'total' => Blog::count(),
                'published' => Blog::where('is_active', true)->count(),
                'this_month' => Blog::whereMonth('created_at', Carbon::now()->month)->count()
            ],
            'projects' => [
                'total' => Project::count(),
                'active' => Project::where('is_active', true)->count(),
                'this_month' => Project::whereMonth('created_at', Carbon::now()->month)->count()
            ]
        ];
        
        $topPages = $pageViewStats['top_pages'];
        
        $chartData = $this->getChartData(7);
        
        $projectViews = PageView::getProjectViews(30);
        
        $projectViewsData = $this->getProjectViewsData(30);
        
        return view('admin.pages.dashboard', compact(
            'pageViewStats',
            'contactStats', 
            'contentStats',
            'topPages',
            'chartData',
            'projectViews',
            'projectViewsData'
        ));
    }
    
    private function getChartData($days = 7)
    {
        $startDate = Carbon::now()->subDays($days - 1);
        $endDate = Carbon::now();
        
        $dailyViews = PageView::whereBetween('view_date', [$startDate, $endDate])
            ->selectRaw('view_date, SUM(view_count) as views')
            ->groupBy('view_date')
            ->orderBy('view_date')
            ->get();
            
        $dailyContacts = ContactSubmission::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as contacts')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        
        // Tạo array đầy đủ cho tất cả các ngày
        $chartData = [];
        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dateStr = $date->format('Y-m-d');
            
            $views = $dailyViews->where('view_date', $dateStr)->first();
            $contacts = $dailyContacts->where('date', $dateStr)->first();
            
            $chartData[] = [
                'date' => $date->format('M d'),
                'views' => $views ? $views->views : 0,
                'contacts' => $contacts ? $contacts->contacts : 0
            ];
        }
        
        return $chartData;
    }
    
    private function getProjectViewsData($days = 30)
    {
        $startDate = Carbon::now()->subDays($days - 1)->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        
        $projects = Project::where('is_active', true)
            ->select('id', 'title', 'slug')
            ->get();
        
        $projectViewsData = [];
        
        foreach ($projects as $project) {
       
            $views = PageView::whereBetween('view_date', [$startDate, $endDate])
                ->where('page_name', 'project_detail')
                ->where(function($query) use ($project) {
                    $query->where('page_url', 'like', '%/projects/' . $project->id)
                          ->orWhere('page_url', 'like', '%/projects/' . $project->slug);
                })
                ->selectRaw('DATE(view_date) as view_date, SUM(view_count) as views')
                ->groupBy(\DB::raw('DATE(view_date)'))
                ->orderBy(\DB::raw('DATE(view_date)'))
                ->get();
            
            $dailyViews = [];
            for ($i = 0; $i < $days; $i++) {
                $date = $startDate->copy()->addDays($i);
                $dateStr = $date->format('Y-m-d');
                
                $dayView = $views->first(function($view) use ($dateStr) {
                    return $view->view_date->format('Y-m-d') === $dateStr;
                });
                
                $dailyViews[] = $dayView ? $dayView->views : 0;
            }
            
            $projectViewsData[] = [
                'id' => $project->id,
                'name' => $project->getTranslation('title', 'vi') ?: $project->getTranslation('title', 'en'),
                'views' => $dailyViews,
                'total_views' => array_sum($dailyViews)
            ];
        }
        
        usort($projectViewsData, function($a, $b) {
            return $b['total_views'] - $a['total_views'];
        });
        
        return array_slice($projectViewsData, 0, 5);
    }
}
