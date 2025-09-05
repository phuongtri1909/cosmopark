<?php

namespace App\Providers;

use App\Models\Project;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ProjectServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $projects = Project::active()
            ->ordered()
            ->select('id', 'title', 'slug', 'hero_image')
            ->get();

        View::composer(
            ['client.layouts.partials.header', 'client.layouts.partials.footer', 'components.zone-slider'],
            function ($view) use ($projects) {
                $view->with('projects', $projects);
            }
        );
    }
}
