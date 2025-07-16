<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('app:update-showtime-status')->everyMinute();