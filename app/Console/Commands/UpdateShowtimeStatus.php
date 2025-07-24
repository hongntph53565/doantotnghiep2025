<?php

namespace App\Console\Commands;

use App\Models\Showtime;
use Illuminate\Console\Command;

class UpdateShowtimeStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-showtime-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        Showtime::whereNotIn('status', ['inactive', 'sold_out'])
            ->where('date', '<=', $now->toDateString())
            ->where('end_time', '<=', $now->format('H:i:s'))
            ->update(['status' => 'sold_out']);
    }
}