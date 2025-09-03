<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use App\Services\ServiceList;
use App\Models\Camera;
use App\Observers\CameraObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(!app()->isProduction());

        View::composer('*', function ($view) {
            $view->with('services', ServiceList::all());
        });

        // Register model observers
        Camera::observe(CameraObserver::class);
    }
}
