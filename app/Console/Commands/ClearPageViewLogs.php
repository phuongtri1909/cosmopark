<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PageView;
use Carbon\Carbon;

class ClearPageViewLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pageviews:clear {--months=3 : Number of months to keep}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear page view logs older than specified months (default: 3 months)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $months = $this->option('months');
        $cutoffDate = Carbon::now()->subMonths($months);
        
        $this->info("Clearing page view logs older than {$months} months (before {$cutoffDate->format('Y-m-d')})...");
        
        $deletedCount = PageView::where('view_date', '<', $cutoffDate)->delete();
        
        $this->info("Successfully deleted {$deletedCount} page view records.");
        
        // Show current stats
        $totalRecords = PageView::count();
        $this->info("Total page view records remaining: {$totalRecords}");
        
        return 0;
    }
}
