<?php

namespace App\Console\Commands;

use App\Models\Showtime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
            ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', end_time), '%Y-%m-%d %H:%i:%s') <= ?", [$now])
            ->update(['status' => 'sold_out']);
    }
}
