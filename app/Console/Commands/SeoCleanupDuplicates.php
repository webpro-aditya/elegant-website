<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SeoCleanupDuplicates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seo:cleanup-duplicates 
                            {--dry-run : Show duplicates without deleting them}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove duplicate SEO entries (same model + model_id), keeping only the latest one.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $seoTable = (new \Modules\Seo\Entities\Seo)->getTable();

        // Get duplicate groups
        $duplicates = DB::table($seoTable)
            ->select('model', 'model_id', DB::raw('COUNT(*) as total'))
            ->groupBy('model', 'model_id')
            ->having('total', '>', 1)
            ->get();

        if ($duplicates->isEmpty()) {
            $this->info('✅ No duplicates found.');
            return Command::SUCCESS;
        }

        foreach ($duplicates as $dup) {
            // Find the latest id for this model + model_id
            $latestId = DB::table($seoTable)
                ->where('model', $dup->model)
                ->where('model_id', $dup->model_id)
                ->max('id');

            // Collect all older IDs
            $toDelete = DB::table($seoTable)
                ->where('model', $dup->model)
                ->where('model_id', $dup->model_id)
                ->where('id', '<', $latestId)
                ->pluck('id');

            if ($toDelete->isEmpty()) {
                continue;
            }

            if ($this->option('dry-run')) {
                $this->warn("Would delete duplicates for {$dup->model} [{$dup->model_id}]: " . implode(', ', $toDelete->toArray()));
            } else {
                DB::table($seoTable)->whereIn('id', $toDelete)->delete();
                $this->info("🗑️ Deleted duplicates for {$dup->model} [{$dup->model_id}]: " . implode(', ', $toDelete->toArray()));
            }
        }

        $this->info('🎉 Cleanup complete.');
        return Command::SUCCESS;
    }
}
