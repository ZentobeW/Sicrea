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

        /**
         * ------------------------------------------------------------
         * Global Facades for ALL Blade Views (fix Route, Storage, etc)
         * ------------------------------------------------------------
         */
        Blade::directive('globalfacades', function () {
            return <<<EOT
<?php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Support\Facades\URL;
?>
EOT;
        });

        /**
         * ------------------------------------------------------------
         * Heroicons Registration (Your existing icons)
         * ------------------------------------------------------------
         */
        $outlineIcons = [
            'arrow-left-on-rectangle',
            'arrow-up-right',
            'building-office',
            'calendar',
            'check',
            'chart-bar-square',
            'clapperboard',
            'credit-card',
            'document-text',
            'envelope',
            'globe-alt',
            'home',
            'light-bulb',
            'magnifying-glass',
            'map-pin',
            'megaphone',
            'phone',
            'photo',
            'pencil-square',
            'plus',
            'x-mark',
            'presentation-chart-bar',
            'trash',
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
