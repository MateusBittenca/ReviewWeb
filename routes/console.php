<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('reviews:send-notifications')
    ->everyFiveMinutes()
    ->withoutOverlapping();

Schedule::command('reviews:clean --days=730')
    ->weeklyOn(0, '02:00');





