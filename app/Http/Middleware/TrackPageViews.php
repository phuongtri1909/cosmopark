<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\PageView;

class TrackPageViews
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($request->isMethod('GET') && !$request->is('admin*') && !$request->is('api*')) {

            if ($this->shouldTrackRoute($request)) {
                try {
                    $pageName = $this->getPageName($request);
                    PageView::trackView($request, $pageName);
                } catch (\Exception $e) {
                    \Log::error('PageView tracking error: ' . $e->getMessage());
                }
            }
        }

        return $response;
    }

    /**
     * Check if this route should be tracked
     */
    private function shouldTrackRoute(Request $request): bool
    {
        $routeName = $request->route() ? $request->route()->getName() : null;
        $path = $request->path();

        $trackableRoutes = [
            'home',          
            'about',         
            'contact',       
            'gallery',       
            'news.index',    
            'news.show',     
            'projects.show', 
        ];
        
        if ($routeName && in_array($routeName, $trackableRoutes)) {
            return true;
        }
        
        $trackablePaths = [
            '',                   
            'about',             
            'contact',           
            'gallery',           
            'news',              
        ];
        
        if (in_array($path, $trackablePaths)) {
            return true;
        }
        
        if (str_starts_with($path, 'news/') || str_starts_with($path, 'projects/')) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine page name from request
     */
    private function getPageName(Request $request): ?string
    {
        $path = $request->path();
        $routeName = $request->route() ? $request->route()->getName() : null;
        
        if ($routeName) {
            $routeMap = [
                'home' => 'home',
                'about' => 'about', 
                'contact' => 'contact',
                'gallery' => 'gallery',
                'news.index' => 'news',
                'news.show' => 'news_detail',
                'projects.show' => 'project_detail',
            ];
            
            if (isset($routeMap[$routeName])) {
                return $routeMap[$routeName];
            }
        }
        
        $pageMap = [
            '' => 'home',
            'about' => 'about',
            'contact' => 'contact', 
            'gallery' => 'gallery',
            'news' => 'news',
            'projects' => 'projects',
        ];

        if (isset($pageMap[$path])) {
            return $pageMap[$path];
        }
        
        if (empty($path) || $path === '/') {
            return 'home';
        }

        if (str_starts_with($path, 'news/')) {
            return 'news_detail';
        }
        
        if (str_starts_with($path, 'projects/')) {
            return 'project_detail';
        }

        return 'other';
    }
}
