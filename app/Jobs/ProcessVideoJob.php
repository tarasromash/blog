<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessVideoJob implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        logs()->info('ProcessVideoJob виконано');
    }
}
