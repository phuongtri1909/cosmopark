<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PageView extends Model
{
    protected $fillable = [
        'ip_address',
        'page_url',
        'page_name',
        'user_agent',
        'referer',
        'view_count',
        'view_date'
    ];

    protected $casts = [
        'view_date' => 'date',
        'view_count' => 'integer'
    ];

    /**
     * Track a page view
     */
    public static function trackView($request, $pageName = null)
    {
        $ip = $request->ip();
        $url = $request->url();
        $userAgent = $request->userAgent();
        $referer = $request->header('referer');
        $today = Carbon::today();

        
        $pageView = self::where('ip_address', $ip)
            ->where('page_url', $url)
            ->where('view_date', $today)
            ->first();

        if ($pageView) {
            // Nếu đã có thì tăng view_count
            $pageView->increment('view_count');
        } else {
            // Nếu chưa có thì tạo mới
            self::create([
                'ip_address' => $ip,
                'page_url' => $url,
                'page_name' => $pageName,
                'user_agent' => $userAgent,
                'referer' => $referer,
                'view_count' => 1,
                'view_date' => $today
            ]);
        }
    }

    /**
     * Get page views statistics
     */
    public static function getStats($days = 30)
    {
        $startDate = Carbon::now()->subDays($days);
        
        return [
            'total_views' => self::where('view_date', '>=', $startDate)->sum('view_count'),
            'unique_visitors' => self::where('view_date', '>=', $startDate)->distinct('ip_address')->count('ip_address'),
            'top_pages' => self::where('view_date', '>=', $startDate)
                ->selectRaw('page_name, SUM(view_count) as total_views')
                ->whereNotNull('page_name')
                ->groupBy('page_name')
                ->orderBy('total_views', 'desc')
                ->limit(10)
                ->get(),
            'daily_views' => self::where('view_date', '>=', $startDate)
                ->selectRaw('view_date, SUM(view_count) as daily_views')
                ->groupBy('view_date')
                ->orderBy('view_date')
                ->get()
        ];
    }

    /**
     * Get project page views specifically
     */
    public static function getProjectViews($days = 30)
    {
        $startDate = Carbon::now()->subDays($days);
        
        return self::where('view_date', '>=', $startDate)
            ->whereIn('page_name', ['project_detail', 'projects'])
            ->sum('view_count');
    }
}
