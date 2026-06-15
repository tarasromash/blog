<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessVideoJob;
use App\Jobs\GenerateCatalog\GenerateCatalogMainJob;

class DiggingDeeperController extends Controller
{
    public function processVideo()
    {
        ProcessVideoJob::dispatch();

        return [
            'success' => true,
            'message' => 'ProcessVideoJob додано в чергу',
        ];
    }

    /**
     * php artisan queue:listen --queue=generate-catalog --tries=3 --delay=10
     */
    public function prepareCatalog()
    {
        GenerateCatalogMainJob::dispatch();

        return [
            'success' => true,
            'message' => 'GenerateCatalogMainJob додано в чергу',
        ];
    }
}
