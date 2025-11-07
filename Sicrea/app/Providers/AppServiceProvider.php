<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
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
        Paginator::useTailwind();
        Carbon::setLocale(config('app.locale'));

        $outlineIcons = [
            'arrow-left-on-rectangle',
            'arrow-up-right',
            'building-office',
            'calendar',
            'chart-bar-square',
            'clapperboard',
            'credit-card',
            'envelope',
            'globe-alt',
            'home',
            'light-bulb',
            'magnifying-glass',
            'map-pin',
            'megaphone',
            'phone',
            'photo',
            'plus',
            'presentation-chart-bar',
            'ticket',
            'user-group',
            'video-camera',
        ];

        foreach ($outlineIcons as $icon) {
            Blade::component('components.heroicon.o.' . $icon, 'heroicon-o-' . $icon);
        }

        Blade::component('components.heroicon.s.heart', 'heroicon-s-heart');
    }
}
