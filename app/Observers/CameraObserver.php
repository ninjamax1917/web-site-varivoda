<?php

namespace App\Observers;

use App\Models\Camera;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class CameraObserver
{
    protected function regenerate(): void
    {
        try {
            Artisan::call('mediamtx:generate-config');
            Log::info('mediamtx:generate-config triggered by Camera change');
        } catch (\Throwable $e) {
            Log::error('Failed to regenerate mediamtx config: ' . $e->getMessage());
        }
    }

    public function created(Camera $camera): void
    {
        $this->regenerate();
    }

    public function updated(Camera $camera): void
    {
        $this->regenerate();
    }

    public function deleted(Camera $camera): void
    {
        $this->regenerate();
    }

    public function restored(Camera $camera): void
    {
        $this->regenerate();
    }

    public function forceDeleted(Camera $camera): void
    {
        $this->regenerate();
    }
}
