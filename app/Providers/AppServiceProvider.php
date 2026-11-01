<?php

namespace App\Providers;

use App\Models\SiteSetting;
use App\Services\ContentSanitizer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
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
        Blade::directive('cleanHtml', function ($expression) {
            return "<?php echo \App\Services\ContentSanitizer::clean($expression); ?>";
        });

        // Share site settings with all views safely
        View::composer('*', function ($view) {
            try {
                $view->with('settings', SiteSetting::current());
            } catch (\Throwable $e) {
                // In case migrations or tables are running
            }
        });
    }
}
