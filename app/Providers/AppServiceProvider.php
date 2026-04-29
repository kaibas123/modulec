<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

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
//        set model ungard
        Model::unguard();
//        set carbon format Y-m-dTH:i:s.vZ
        Carbon::serializeUsing(function($date) {
            return $date->format("Y-m-d\TH:i:s\.v\Z");
        });
    }
}
