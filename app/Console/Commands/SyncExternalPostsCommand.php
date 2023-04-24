<?php

namespace App\Console\Commands;

use App\Actions\SyncExternalPost;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Fork\Fork;

class SyncExternalPostsCommand extends Command
{
    protected $signature = 'sync:externals {--async}';

    protected $description = 'Sync external RSS feeds';

    public function handle(SyncExternalPost $sync)
    {
        $feeds = config('services.external_feeds');

        $this->info('Fetching ' . count($feeds) . ' feeds');

        $this->option('async')
            ? $this->syncAsync($feeds, $sync)
            : $this->sync($feeds, $sync);

        $this->info('Done');
    }

    private function syncAsync(array $feeds, SyncExternalPost $sync): void
    {
        Fork::new()
            ->before(child: fn () => DB::connection('mysql')->reconnect())
            ->concurrent(10)
            ->run(...array_map(function (string $url) use ($sync) {
                return function () use ($sync, $url) {
                    $this->comment("\t- $url");

                    $sync($url);
                };
            }, $feeds));
    }

    private function sync(array $feeds, SyncExternalPost $sync)
    {
        foreach ($feeds as $url) {
            $this->info("\t- $url");

            $sync($url);
        }
    }
}
